<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Page;
use AppBundle\Entity\Bank;

use AppBundle\Entity\Loan;
use AppBundle\Entity\LoanGroup;

use AppBundle\Entity\Deposit;
use AppBundle\Entity\DepositDay;

use AppBundle\Entity\Currency;

use AppBundle\Entity\ArmRegion;
use AppBundle\Entity\ArmAdministrative;

use AppBundle\Entity\TransferType;

use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BankController extends Controller
{
    
    private $locale;
    private $customerType = null;
    
    /**
     * @Route("/{_locale}/banks-and-branches/{bankSlug}", name="bank_banks_branches", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function getBanksBranchesAction(Request $request, $bankSlug = null)
    {
        
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();
        
        $repositoryBanks = $manager->getRepository('AppBundle:Bank');
        $repositoryBankBranches = $manager->getRepository('AppBundle:BankBranch');
        $repositoryPages = $manager->getRepository('AppBundle:Page');

        $selectedBank = array();
        $banks = $repositoryBanks->findAll(array('bankOrder' => 'DESC'));
        
        if($bankSlug !== null){ $selectedBank = $repositoryBanks->findOneByBankSlug($bankSlug); }
        
        $page = $repositoryPages->findOneByPageSlug('banks-and-branches');
        
        $page->setLocale($locale);
        $manager->refresh($page);
        
        foreach($banks as $bank){
            $bank->setLocale($locale);
            $manager->refresh($bank);
        }
        
        if($bankSlug !== null){ 
            $selectedBank->setLocale($locale);
            $manager->refresh($selectedBank);
        }

        return $this->render('bank/banks_and_branches.html.twig', array(
            'page' => $page,
            'banks' => $banks,
            'selectedBank' => $selectedBank
        ));
    }
    
    /**
     * @Route("/{_locale}/bank-atms", name="bank_atms", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function getBanksAtmsAction(Request $request)
    {
        
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();
        
        $repositoryBanks = $manager->getRepository('AppBundle:Bank');
        $repositoryPages = $manager->getRepository('AppBundle:Page');
        
        $banks = $repositoryBanks->findAll();
        $page = $repositoryPages->findOneByPageSlug('bank-atms');
        
        $page->setLocale($locale);
        $manager->refresh($page);
        
        foreach($banks as $bank){
            $bank->setLocale($locale);
            $manager->refresh($bank);
        }
        
        return $this->render('bank/bank_atms.html.twig', array(
            'page' => $page,
            'banks' => $banks
        ));
    }


    

    /**
     * Matches /bank-loans exactly
     * 
     * @Route("/{_locale}/bank-loans/{entity_type}", name="bank_loans", requirements={
     *         "_locale": "hy|en"
     *     }))
     */
    public function getBankLoansAction(Request $request, $entity_type)
    {

        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();

        $this->locale = $locale;

        $filterCurrency = "";

        $loans = array();
        $entity_types = array(
            'physical' => 0,
            'legal' => 1,
            'farmer' => 2
        );
        
        if(isset($entity_types[$entity_type])){
            $customer_type = $entity_types[$entity_type];
        } else {
            throw new NotFoundHttpException("Page not found");
        }

        $this->customerType = $customer_type;

        $repositoryBanks = $manager->getRepository('AppBundle:Bank');
        $repositoryLoanGroups = $manager->getRepository('AppBundle:LoanGroup');
        $repositoryCurrencies = $manager->getRepository('AppBundle:Currency');
        $repositoryPages = $manager->getRepository('AppBundle:Page');
        
        $page = $repositoryPages->findOneByPageSlug('bank-loans');
        
        $loan = new Loan();

        $form = $this->createFormBuilder($loan)
            ->add('loanGroup', 'entity', array(
                'class' => 'AppBundle:LoanGroup',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('lg')
                        ->where('l.loanCustomerType = :customerType')
                        ->join('AppBundle:Loan', 'l', 'WITH', 'l.loanGroup = lg')
                        ->orderBy('lg.loanGroupOrder', 'ASC')
                        ->setParameter('customerType', $this->customerType)
                    ;
                },
                'property' => 'loanGroupTitle',
                'expanded' => false,
                'multiple' => false
            ))
            ->add('currency', 'entity', array(
                'class' => 'AppBundle:Currency',
                'property' => 'currencySymbol',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                            ->innerJoin('AppBundle:Loan', 'l', 'WITH', 'c.currencyId = l.currencyId')
                            ->groupBy('c.currencyId')
                            ->orderBy('c.currencyOrder', 'ASC')
                            ;
                },
                'expanded' => false,
                'multiple' => false
            ))
            ->add('loanTermsMin', 'integer', array('required' => false))
            ->add('loanMin', 'integer', array('required' => false))
            ->add('filter', 'submit', array('label' => $this->get('translator')->trans('Փնտրել')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $loan = $form->getData();
            
            $loan_group = $loan->getLoanGroup();
            $currency_group = $loan->getCurrency();
            
            $loan_group_id = $loan_group->getLoanGroupId();
            $currency_id = $currency_group->getCurrencyId();
            $loan_terms_min = $loan->getLoanTermsMin();
            $loan_min = $loan->getLoanMin();
            
            $filterCurrency = $currencies = $repositoryCurrencies->findOneByCurrencyId($currency_id);
            
            $loans = $repositoryBanks->findLoansByInputFields($currency_id, $loan_group_id, $loan_terms_min, $loan_min, $customer_type);
            
        }
        
        $loanGroups = $repositoryLoanGroups->findAll();
        $currencies = $repositoryCurrencies->findAll();
        
        $page->setLocale($locale);
        $manager->refresh($page);
        
        foreach($loanGroups as $loanGroup){
            $loanGroup->setLocale($locale);
            $manager->refresh($loanGroup);
        }

        foreach($currencies as $currency){
            $currency->setLocale($locale);
            $manager->refresh($currency);
        }

        return $this->render('bank/bank_loans.html.twig', array(
            'page' => $page,
            'loans' => $loans,
            'loanGroups' => $loanGroups,
            'currencies' => $currencies,
            'filterCurrency' => $filterCurrency,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Matches /bank-deposits exactly
     * 
     * @Route("/{_locale}/bank-deposits/{entity_type}", name="bank_deposits", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function getBankDepositsAction(Request $request, $entity_type)
    {

        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();

        $deposits = array();
        $entity_types = array(
            'physical' => 0,
            'legal' => 1
        );
        
        if(isset($entity_types[$entity_type])){
            $customer_type = $entity_types[$entity_type];
        } else {
            throw new NotFoundHttpException("Page not found");
        }
        
        $repositoryPages = $this->getDoctrine()->getRepository('AppBundle:Page');
        $page = $repositoryPages->findOneBy(['pageSlug'=>'bank-deposits']);

        $repositoryBanks = $this->getDoctrine()->getRepository('AppBundle:Bank');
        $repositoryDeposits = $this->getDoctrine()->getRepository('AppBundle:Deposit');
        $repositoryCurrencies = $this->getDoctrine()->getRepository('AppBundle:Currency');
        
        $data = array();
        $form_builder = $this->createFormBuilder($data)
            ->add('currency', 'entity', array(
                'class' => 'AppBundle:Currency',
                'property' => 'currencySymbol',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                            ->innerJoin('AppBundle:Deposit', 'd', 'WITH', 'c.currencyId = d.currencyId')
                            ->groupBy('c.currencyId')
                            ->orderBy('c.currencyOrder', 'ASC')
                            ;
                },
                'expanded' => false,
                'multiple' => false
            ))
            ->add('depositDays', 'integer', array('required' => false))
            ->add('depositMonths', 'integer', array('required' => false))
            ->add('depositMin', 'integer')
            ->add('filter', 'submit', array('label' => $this->get('translator')->trans('Փնտրել')))
            ->getForm();

        $form_builder->handleRequest($request);
        
        if ($form_builder->isSubmitted() && $form_builder->isValid()) {
            
            $data = $form_builder->getData();
            
            $currency_id = $data['currency']->getCurrencyId();
            $deposit_days = (!empty($data['depositDays'])) ? $data['depositDays'] : null;
            $deposit_months = (!empty($data['depositMonths'])) ? $data['depositMonths'] : null;
            $deposit_min = $data['depositMin'];

            if(null != $deposit_days || null != $deposit_months)
                $deposits = $repositoryDeposits->findDepositsByInputFields($currency_id, $deposit_days, $deposit_months, $deposit_min, $customer_type);
            else
                $deposits = null;

        }

        $currencies = $repositoryCurrencies->findAll();
//        if($request->getLocale() == 'en') {
//
//            $data = [];
//            foreach ($page->getTranslations() as $key => $pageV) {
//                if ($pageV->getLocale() == "en") {
//                    dump($pageV);
//                    array_push($data, $pageV->getContent());
//                }
//            }
//            $page->setPageTitle($data[0]);
//            $page->setPageMetaKeywords($data[1]);
//            $page->setPageMetaDescription($data[2]);
//
//            $page->setPageText($data[3]);
//        }

        $page->setLocale($locale);
        $manager->refresh($page);

        return $this->render('bank/bank_deposits.html.twig', array(
            'page' => $page,
            'deposits' => $deposits,
            'currencies' => $currencies,
            'form' => $form_builder->createView()
        ));
        
    }







    /**
     * Matches /bank-transfers
     * 
     * @Route("/{_locale}/bank-transfers", name="bank_transfers", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function getBankTransfersAction(Request $request)
    {
        
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();
        $banks = array();
        
        $repositoryBanks = $manager->getRepository('AppBundle:Bank');
        $repositoryPages = $manager->getRepository('AppBundle:Page');
        $repositoryCountries = $manager->getRepository('AppBundle:Country');
        
        $page = $repositoryPages->findOneByPageSlug('bank-transfers');
        $countries = $repositoryCountries->findAll();
        
        $data = array();
        $form_builder = $this->createFormBuilder($data)
            ->add('country', 'entity', array(
                'class' => 'AppBundle:Country',
                'property' => 'countryTitle',
                'expanded' => false,
                'multiple' => false
            ))
            ->add('currency', 'entity', array(
                'class' => 'AppBundle:Currency',
                'property' => 'currencySymbol',
                'expanded' => false,
                'multiple' => false
            ))
            ->add('method', 'entity', array(
                'class' => 'AppBundle:TransferType',
                'property' => 'transferTypeTitle',
                'query_builder' => function(EntityRepository $er){ 
                    return $er->createQueryBuilder('tt')
                            ->where('tt.transferTypeId <> 10 AND tt.transferTypeId <> 11 AND tt.transferTypeId <> 12')
                            ->orderBy('tt.transferTypeOrder', 'ASC');
                },
                'expanded' => false,
                'multiple' => false
            ))
            ->add('money', 'number')
            ->add('filter', 'submit', array('label' => $this->get('translator')->trans('Փնտրել')))
            ->getForm();
        
        $form_builder->handleRequest($request);
        
        if ($form_builder->isSubmitted() && $form_builder->isValid()) {
            
            $data = $form_builder->getData();
            
            $country_id = $data['country']->getCountryId();
            $currency_id = $data['currency']->getCurrencyId();
            $transfer_type_id = $data['method']->getTransferTypeId();
            $money = $data['money'];
            
            $banks = $repositoryBanks->findTransfersByInputFields($country_id, $transfer_type_id, $money, $currency_id);
//            $queryBanks = $repositoryBanks->createQueryBuilder('b')
//                    ->addSelect('t.transferId')
//                    ->addSelect('tt.transferTypeId')
//                    ->addSelect('tt.transferTypeTitle')
//                    ->addSelect('c.currencyId')
//                    ->addSelect('c.currencySymbol')
//                    ->addSelect('tcu.transferCurrencyMin')
//                    ->addSelect('tcu.transferCurrencyMax')
//                    ->addSelect('t.transferComMin')
//                    ->addSelect('t.transferComMax')
//                    ->addSelect('t.transferComPercent')
//                    ->addSelect('t.transferSpeedMinute')
//                    ->addSelect('t.transferOtherConditions')
//                    ->addSelect('t.transferDescription')
//                    ->addSelect('t.transferLink')
//                    ->addSelect('t.transferUpdateDate')
//                    ->addSelect('tcu.transferCurrencyIo')
//                    
//                    ->innerJoin('AppBundle:Transfer', 't', 'WITH', 't.bankId = b.bankId')
//                    ->innerJoin('AppBundle:TransferType', 'tt', 'WITH', 't.transferTypeId = tt.transferTypeId')
//                    ->innerJoin('AppBundle:CountryTransfer', 'ct', 'WITH', 'ct.transferId = t.transferId')
//                    ->innerJoin('AppBundle:TransferCurrency', 'tcu', 'WITH', 'tcu.transferId = t.transferId AND tcu.currencyId = :currency_id AND tcu.transferCurrencyIo = 0')
//                    ->innerJoin('AppBundle:Currency', 'c', 'WITH', 'c.currencyId = tcu.currencyId')
//                    
//                    ->where('tcu.transferCurrencyMin <= :transfer_amount')
//                    ->andWhere('tcu.transferCurrencyMax >= :transfer_amount')
//                    ->andWhere('t.transferTypeId = :transfer_type_id')
//                    ->andWhere('ct.countryId = :country_id')
//                    ->andWhere('t.transferTypeId <> 10')
//                    ->andWhere('t.transferTypeId <> 11')
//                    ->andWhere('t.transferTypeId <> 12')
//                    
//                    ->setParameter('currency_id', $currency_id)
//                    ->setParameter('transfer_amount', $money)
//                    ->setParameter('transfer_type_id', $transfer_type_id)
//                    ->setParameter('country_id', $country_id)
//                    ->getQuery()
//                    ;
//            $banks = $queryBanks->getResult();
            
//            foreach($banks as $bank){
//                $bank->setLocale($locale);
//                $manager->refresh($bank);
//            }
            
        }
        
        $page->setLocale($locale);
        $manager->refresh($page);
        
        return $this->render('bank/bank_transfers.html.twig', array(
            'page' => $page,
            'banks' => $banks,
            'countries' => $countries,
            'form' => $form_builder->createView()
        ));
        
    }
    
    /**
     * Matches /bank-transfers-swift
     * 
     * @Route("/{_locale}/bank-transfers-swift", name="bank_transfers_swift", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function getBankTransfersSwiftAction(Request $request){
        
        $banks = array();
        
        $repositoryBanks = $this->getDoctrine()->getRepository('AppBundle:Bank');
        $repositoryTransferType = $this->getDoctrine()->getRepository('AppBundle:TransferType');
        
        $repositoryPages = $this->getDoctrine()->getRepository('AppBundle:Page');
        $page = $repositoryPages->findOneByPageSlug('bank-transfers-swift');
        
        $data = array();
        $form_builder = $this->createFormBuilder($data)
            ->add('method', 'entity', array(
                'class' => 'AppBundle:TransferType',
                'property' => 'transferTypeTitle',
                'query_builder' => function(EntityRepository $er){ 
                    return $er->createQueryBuilder('tt')
                            ->where('tt.transferTypeId = 10 OR tt.transferTypeId = 11 OR tt.transferTypeId = 12')
                            ->orderBy('tt.transferTypeOrder', 'ASC');
                },
                'expanded' => false,
                'multiple' => false
            ))
            ->add('currency', 'entity', array(
                'class' => 'AppBundle:Currency',
                'property' => 'currencySymbol',
                'expanded' => false,
                'multiple' => false
            ))
            ->add('filter', 'submit', array('label' => $this->get('translator')->trans('Փնտրել')))
            ->getForm();
        
        $form_builder->handleRequest($request);
        
        if ($form_builder->isSubmitted() && $form_builder->isValid()) {
            
            $data = $form_builder->getData();
            
            $currency_id = $data['currency']->getCurrencyId();
            $transfer_type_id = $data['method']->getTransferTypeId();
            
            $banks = $repositoryBanks->findSwiftTransfersByInputFields($transfer_type_id, $currency_id);
            
        }
        
        return $this->render('bank/bank_transfers_swift.html.twig', array(
            'page' => $page,
            'banks' => $banks,
            'form' => $form_builder->createView()
        ));
        
    }
    
    /**
     * Matches /bank-e-wallets
     * 
     * @Route("/{_locale}/bank-e-wallets", name="bank_ewallet", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function getBankEwalletRefillsAction (Request $request) 
    {
        
        $repositoryBanks = $this->getDoctrine()->getRepository('AppBundle:Bank');
        
        $repositoryPages = $this->getDoctrine()->getRepository('AppBundle:Page');
        $page = $repositoryPages->findOneByPageSlug('bank-e-wallets');
        
        $banks = array();
        $data = array();
        $form_builder = $this->createFormBuilder($data)
            ->add('wallet', 'entity', array(
                'class' => 'AppBundle:Ewallet',
                'property' => 'ewalletTitle',
                'expanded' => false,
                'multiple' => false
            ))
            ->add('filter', 'submit', array('label' => 'Փնտրել'))
            ->getForm();
        
        $form_builder->handleRequest($request);
        
        if ($form_builder->isSubmitted() && $form_builder->isValid()) {
            
            $data = $form_builder->getData();
            
            $wallet_id = $data['wallet']->getEwalletId();
            
            $banks = $repositoryBanks->findWalletRatesByInputFields($wallet_id);
            
        }
        
        return $this->render('bank/bank_ewallets.html.twig', array(
            'page' => $page,
            'banks' => $banks,
            'form' => $form_builder->createView()
        ));
        
    }
    
    /**
     * Matches /central-bank exactly
     * 
     * @Route("/{_locale}/central-bank/{currency}/{year}", name="bank_cba", requirements={
     *         "_locale": "hy|en",
     *         "currency": "[a-z]{3}",
     *         "year": "[0-9]{4}"
     *     },
     *  defaults={
     *      "_locale": "hy"
     *  }
     * 
     * )
     */
    public function getBanksCbaAction(Request $request, $currency = null, $year = null)
    {

        $toDay = new \DateTime();
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();

        $yearCurrent = (int) date('Y');
        $yearNext = $yearCurrent + 1;
        $currencyDefault = 'usd';

        $em = $this->getDoctrine()->getManager();

        $repositoryPages = $manager->getRepository('AppBundle:Page');
        $repositoryCbaRates = $manager->getRepository('AppBundle:CbaRate');

        $page = $repositoryPages->findOneByPageSlug('central-bank');

        $page->setLocale($locale);
        $manager->refresh($page);

        if(!is_null($currency)){ $currencyDefault = $currency; }
        if(!is_null($year)) { $yearCurrent = $year; $yearNext = $yearCurrent + 1; }

        $cba_rates = $repositoryCbaRates->findCbaRatesByDateRangeAndCurrency($yearCurrent.'-01-01 00:00:00', $yearNext.'-01-01 00:00:00', $currencyDefault);


        $queryMaxYear = $em->createQuery('SELECT MAX(cr.cbaRateUpdateDate)FROM AppBundle:CbaRate cr');
        $maxYearResult = $queryMaxYear->getResult();
        $maxYear = (int) date('Y', strtotime($maxYearResult[0][1]));

        $repositoryCurrencies = $this->getDoctrine()->getRepository('AppBundle:Currency');
        $currencies = $repositoryCurrencies->findBy(array(), array('currencyOrder' => 'ASC'));

        // Month summary
        $monthSummary = array();



        $correctArray = array();
        $index = 0;
        $nullArray = array(
            "day" => null,
            "mn_1" => null,
            "mn_2" => null,
            "mn_3" => null,
            "mn_4" => null,
            "mn_5" => null,
            "mn_6" => null,
            "mn_7" => null,
            "mn_8" => null,
            "mn_9" => null,
            "mn_10" => null,
            "mn_11" => null,
            "mn_12" => null,
        );

        for ($i = 0 ; $i < 31 ; $i++){
            if($cba_rates[$index]['day'] != ($i + 1)) {
                $nullArray['day'] = $i + 1;
                $correctArray[$i] = $nullArray;
            }
            else{
                $correctArray[$i] = $cba_rates[$index];
                $index++;
            }
        };
        $cba_rates = $correctArray;

/*

        foreach($cba_rates as $cb_key => $cbRate){

            foreach($cbRate as $key => $mnDayRate){

                if($key !== 'day'){
                    if($mnDayRate == null){
                        $month = str_replace('mn_', '', $key);
                        $day = $cbRate['day'];

                        if(intval($month) <= 9){ $month = "0".$month; }
                        if(intval($day) <= 9){ $day = "0".$day; }

                        $currentDate = $yearCurrent.'-'.$month.'-'.$day;
                        $currentDateDiff = $yearCurrent.$month.$day;
                        $previousDate = $yearCurrent.'-'.$month.'-01';

                        if($day == "01"){ $previousDate = $yearCurrent.'-'.($month-1).'-01'; }
                        if($month == "01"){ $previousDate = ($yearCurrent-1).'-12-01'; }

                        $dayOfTheWeek = date("N", strtotime($currentDate));
                        $daysOfMonth = cal_days_in_month(CAL_GREGORIAN, intval($month), $yearCurrent);

                        if($dayOfTheWeek !== "7" && intval($day) <= $daysOfMonth){
                            $latestNotNullRate = $repositoryCbaRates->getLatestNotNullRate($previousDate, $currentDate, $currencyDefault);
                            if(!empty($latestNotNullRate)){
                                if( (int)$toDay->format('Ymd') >= (int)$currentDateDiff && (int)$toDay->format('Gis') > 170000 ) {
                                    $cba_rates[$cb_key][$key] = $latestNotNullRate[0]['cba_rate_rate'];
                                }
                            }
                        }
                    }
                }
            }
        }

*/
        foreach($cba_rates as $cb_key => $cbRate){

            foreach($cbRate as $key => $mnDayRate){

                if($key !== 'day'){

                    if(!isset($monthSummary[$key]['min']) || ($mnDayRate > 0 && $monthSummary[$key]['min'] > $mnDayRate)){
                        $monthSummary[$key]['min'] = $mnDayRate;
                    }
                    if(!isset($monthSummary[$key]['max']) || $monthSummary[$key]['max'] < $mnDayRate){
                        $monthSummary[$key]['max'] = $mnDayRate;
                    }

                    if(!isset($monthSummary[$key]['avgSum'])){
                        $monthSummary[$key]['avgSum'] = $mnDayRate;
                    } else {
                        $monthSummary[$key]['avgSum'] += $mnDayRate;
                    }

                    if(!isset($monthSummary[$key]['avgCount'])){
                        if(!empty($mnDayRate)) {
                            $monthSummary[$key]['avgCount'] = 1;
                        }
                    } else {
                        if(!empty($mnDayRate)){
                            $monthSummary[$key]['avgCount'] += 1;
                        }
                    }
                }
            }
        }



        return $this->render('bank/bank_cba.html.twig', array(
            'page' => $page,
            'cba_rates' => $cba_rates,
            'monthSummary' => $monthSummary,
            'currencies' => $currencies,
            'maxYear' => $maxYear,
            'currentYear' => $yearCurrent,
            'currentCurrency' => $currencyDefault
        ));
    }
    
    /**
     * @Route("/central-bank/migrate", name="bank_cba_migrate")
     */
    public function getBanksCbaMigrationAction (Request $request){
        
        return $this->render('bank/bank_cba_migrate.html.twig');
        
    }
    
    /**
     * @Route("/central-bank/create", name="bank_cba_create")
     */
    public function createBanksCbaRateAction(Request $request)
    {
        
//        if(false){
//        if(false){

            $dateNow = new \DateTime('now');
            $cba_update_date = new \DateTime($request->get('date_current'));

            $cba_rate = new CbaRate();
            $cba_rate->setCbaRateCurrencyIso($request->get('iso'));
            $cba_rate->setCbaRateAmmount($request->get('amount'));
            $cba_rate->setCbaRateRate($request->get('rate'));
            $cba_rate->setCbaRateGetDate($dateNow);
            $cba_rate->setCbaRateUpdateDate($cba_update_date);

            $em = $this->getDoctrine()->getManager();

            $em->persist($cba_rate);
            $em->flush();
            return new JsonResponse($cba_rate->getCbaRateId());
        
//        }
        
    }
    
    
    
}
