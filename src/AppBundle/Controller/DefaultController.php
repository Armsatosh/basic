<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\ArmRegion;
use AppBundle\Entity\Page;
use AppBundle\Entity\Bank;

class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}/{slug}/{type}/{dateTime}", name="homepage",
     *  requirements={
     *      "_locale": "hy|en",
     *      "slug":"cash|non-cash",
     *      "type":"direct|crossed"
     *  },
     *  defaults={
     *      "_locale": "hy",
     *       "slug":"cash",
     *       "type":"direct"
     *  }
     * )
     */
    public function indexAction(Request $request,$slug="cash",$type='direct',$dateTime='')
    {

        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();


        $repositoryPages = $manager->getRepository('AppBundle:Page');
        $repositoryBanks = $manager->getRepository('AppBundle:Bank');
        $repositoryRates = $manager->getRepository('AppBundle:RateCurrent');
        $repositorySlides = $manager->getRepository('AppBundle:Slide');
        $repositoryNews = $manager->getRepository('AppBundle:News');
        $ratesRepository=$this->getDoctrine()->getRepository('AppBundle:Rate');
        $page = $repositoryPages->findOneByPageSlug('home');
        $slides = $repositorySlides->findBy(array(), array('slideOrder' => 'ASC'));
        $banks = $repositoryBanks->findAll();
        $news = $repositoryNews->findBy(array(), array('newsDate' => 'DESC'), 6, 0);


        foreach($news as $new){
            $new->setLocale($locale);
            $manager->refresh($new);
        }

        $latestRecordDate = $repositoryRates->getLatestRecordDate();
        $rateUpdatDate = $latestRecordDate->getRateUpdateDate();

        $latestHSBCRecordDate = $repositoryRates->getHSBCLatestRecordDate();

        $rateHSBCUpdatDate = null;

        if($latestHSBCRecordDate){
            $rateHSBCUpdatDate = $latestHSBCRecordDate->getRateUpdateDate();
        }

        $rates = $repositoryBanks->getLatestRates();

        /*var_dump($rates);
        die;*/
        foreach($banks as $bank){
            $bank->setLocale($locale);
            $manager->refresh($bank);
        }

        $page->setLocale($locale);
        $manager->refresh($page);


        $minRateDate=$ratesRepository->findOneBy(
            array(),
            array('rateUpdateDate'=>'ASC'),
            1
        );

        if($request->get('rate-date')) {
            $time = $request->get('rate-date')."T".$request->get('rate-time');

            $url = $this->generateUrl(
                'homepage',
                array(
                    'dateTime' => $time,
                    'slug' => $slug,
                    'type' => $type
                )
            );
            return $this->redirect($url);
        }


        if($dateTime!='') {
            $dateInRequest=new \DateTime($dateTime);


            $datePrew = date_create();
            date_timestamp_set($datePrew, $dateInRequest->getTimestamp());
            $dateNext = date_create();
            date_timestamp_set($dateNext, $dateInRequest->getTimestamp()+604800);


//          echo 'Date Prew: ' . $datePrew->format("Y-m-d H:i:s") . ' Date Next: ' . $dateNext->format("Y-m-d H:i:s");
//           die;

            $rateMinDate = $ratesRepository->createQueryBuilder('r')
                ->where('r.rateUpdateDate>=:datePrew')
                ->andWhere('r.rateUpdateDate<=:dateNext')
                ->setParameter('datePrew',$datePrew)
                ->setParameter('dateNext',$dateNext)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();



            if(null != $rateMinDate) {

                $date = $rateMinDate->getRateUpdateDate()->format('Y-m-d H:i:s');

                $dateObj = new \DateTime($date);
                $dateNext = date_create();
                date_timestamp_set($dateNext, $dateObj->getTimestamp()+300);

                $ratesObject = $ratesRepository->createQueryBuilder('r')
                        ->where('r.rateUpdateDate>=:datePrew')
                        ->andWhere('r.rateUpdateDate<=:dateNext')
                        ->setParameter('datePrew', $date)
                        ->setParameter('dateNext', $dateNext)

                    ->getQuery()
                    ->getArrayResult();
                $rates = array();
                $index = 0;

                foreach ($ratesObject as $rate) {
                    $rates[$index]['currency_id'] = $rate['currencyId'];
                    $rates[$index]['rate_sell'] = $rate['rateSell'];
                    $rates[$index]['rate_buy'] = $rate['rateBuy'];
                    $rates[$index]['bank_id'] = $rate['bankId'];
                    $rates[$index]['rate_non_cash_buy'] = $rate['rateNonCashBuy'];
                    $rates[$index]['rate_non_cash_sell'] = $rate['rateNonCashSell'];
                    $index++;
                }
            } else{
              // echo "else !!!";die;
               $rates = array();
            }
        }

        /*var_dump($rates);
        die;*/

        $sortArray = array();
        foreach($rates as $person){
            foreach($person as $key=>$value){
                if(!isset($sortArray[$key])){
                    $sortArray[$key] = array();
                }
                $sortArray[$key][] = $value;
            }
        }
        /*echo('<pre>');
        var_dump($rates);die();*/
        $orderby = "bank_id";
        if (!empty($sortArray)) {
            array_multisort($sortArray[$orderby],SORT_ASC,$rates);
        }

        if($type=='crossed'){
            $ratesObject=$rates;

            if(count($ratesObject) > 0) {

                $rates = array();
                $bankId = $ratesObject[0]['bank_id'];

                foreach ($ratesObject as $rate) {

                    if ($bankId != $rate['bank_id']) {
                        $USD = $EUR = $RUB = $GBP = null;
                        $bankId = $rate['bank_id'];
                    }

                    if ($slug == "cash") {

                        if ($rate['currency_id'] == 10) {
                            $EUR['sell'] = $rate['rate_sell'];
                            $EUR['buy'] = $rate['rate_buy'];
                        }
                        if ($rate['currency_id'] == 1) {
                            $USD['sell'] = $rate['rate_sell'];
                            $USD['buy'] = $rate['rate_buy'];
                        }
                        if ($rate['currency_id'] == 51) {
                            $RUB['sell'] = $rate['rate_sell'];
                            $RUB['buy'] = $rate['rate_buy'];
                        }
                        if ($rate['currency_id'] == 2) {
                            $GBP['sell'] = $rate['rate_sell'];
                            $GBP['buy'] = $rate['rate_buy'];
                        }
                    } else {

                        if ($rate['currency_id'] == 10) {
                            $EUR['sell'] = $rate['rate_non_cash_sell'];
                            $EUR['buy'] = $rate['rate_non_cash_buy'];
                        }
                        if ($rate['currency_id'] == 1) {
                            $USD['sell'] = $rate['rate_non_cash_sell'];
                            $USD['buy'] = $rate['rate_non_cash_buy'];
                        }
                        if ($rate['currency_id'] == 51) {
                            $RUB['sell'] = $rate['rate_non_cash_sell'];
                            $RUB['buy'] = $rate['rate_non_cash_buy'];
                        }
                        if ($rate['currency_id'] == 2) {
                            $GBP['sell'] = $rate['rate_non_cash_sell'];
                            $GBP['buy'] = $rate['rate_non_cash_buy'];
                        }
                    }


                        $rates[$bankId]['EUR/USD'] = null;
                        $rates[$bankId]['USD/EUR'] = null;
                        $rates[$bankId]['EUR/RUB'] = null;
                        $rates[$bankId]['EUR/RUB'] = null;
                        $rates[$bankId]['RUB/EUR'] = null;
                        $rates[$bankId]['USD/RUB'] = null;
                        $rates[$bankId]['RUB/USD'] = null;
                        $rates[$bankId]['GBP/EUR'] = null;
                        $rates[$bankId]['EUR/GBP'] = null;


                    if (isset($EUR) && isset($USD)) {
                        try {
                            $rates[$bankId]['EUR/USD'] = round(($EUR['buy'] / $USD['sell']), 4);
                        } catch (\Exception $e) {
                            $rates[$bankId]['EUR/USD'] = null;
                        }
                        try {
                            $rates[$bankId]['USD/EUR'] = round(($USD['buy'] / $EUR['sell']), 4);
                        } catch (\Exception $e) {
                            $rates[$bankId]['USD/EUR'] = null;
                        }
                    }
                    if (isset($EUR) && isset($RUB)) {
                        try {
                            $rates[$bankId]['EUR/RUB'] = round(($EUR['buy'] / $RUB['sell']), 4);
                        } catch (\Exception $e) {
                            $rates[$bankId]['EUR/RUB'] = null;
                        }
                        try {
                            $rates[$bankId]['RUB/EUR'] = round(($RUB['buy'] / $EUR['sell']), 4);
                        } catch (\Exception $e) {
                            $rates[$bankId]['RUB/EUR'] = null;
                        }
                    }
                    if (isset($USD) && isset($RUB)) {
                        try {
                            $rates[$bankId]['USD/RUB'] = round(($USD['buy'] / $RUB['sell']), 4);
                        } catch (\Exception $e) {
                            $rates[$bankId]['USD/RUB'] = null;
                        }
                        try {
                            $rates[$bankId]['RUB/USD'] = round(($RUB['buy'] / $USD['sell']), 4);
                        } catch (\Exception $e) {
                            $rates[$bankId]['RUB/USD'] = null;
                        }
                    }
                    if (isset($EUR) && isset($GBP)) {
                        try {
                            $rates[$bankId]['EUR/GBP'] = round(($EUR['buy'] / $GBP['sell']), 4);
                        } catch (\Exception $e) {
                            $rates[$bankId]['EUR/GBP'] = null;
                        }
                        try {
                            $rates[$bankId]['GBP/EUR'] = round(($GBP['buy'] / $EUR['sell']), 4);
                        } catch (\Exception $e) {
                            $rates[$bankId]['GBP/EUR'] = null;
                        }
                    }

                }

                foreach ($banks as $keyBank => $bank) {

                    $haveBank = false;
                    foreach ($rates as $keyRate => $rate) {
                        if ($keyBank == $keyRate) {
                            $haveBank = true;
                            break;
                        }
                    }
                    if ($haveBank == false) {
                        $rates[$keyBank] = null;
                    }
                }
            }
        }


        return $this->render('default/index.html.twig', array(
            'page' => $page,
            'slides' => $slides,
            'banks' => $banks,
            'rates' => $rates,
            'rateUpdatDate' => $rateUpdatDate,
            'rateHSBCUpdatDate' => $rateHSBCUpdatDate,
            'news' => $news,
            'minRateDate' => $minRateDate->getRateUpdateDate()->format('Y-m-d'),
            'dateTime' => $dateTime
        ));
    }


    /**
     * @Route("/{_locale}/about-us", name="default_about", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function aboutAction(Request $request)
    {
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();
        
        $repositoryPages = $manager->getRepository('AppBundle:Page');
        $page = $repositoryPages->findOneByPageSlug('about');
        
        $page->setLocale($locale);
        $manager->refresh($page);
        
        return $this->render('default/about.html.twig', array(
            'page' => $page
        ));
        
    }
    
    /**
     * @Route("/{_locale}/contact-us", name="default_contact", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function contactAction(Request $request)
    {
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();
        
        $repositoryPages = $manager->getRepository('AppBundle:Page');
        $page = $repositoryPages->findOneByPageSlug('contact');
        
        $page->setLocale($locale);
        $manager->refresh($page);
        
        
        $contact_form_data = array();
        
        $contactForm = $this->createFormBuilder($contact_form_data)
                ->add('firstName', 'text')
                ->add('email', 'email')
                ->add('message', 'textarea')
                ->add('save', 'submit', array('label' => 'Ուղարկել'))
                ->getForm();
        
        $contactForm->handleRequest($request);
        
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            
            $isRobot = true;
            $captchaResponse = $request->get('g-recaptcha-response');
            
            if(!empty($captchaResponse)){
                $isRobot = false;
            }

            if(!$isRobot){
                
                $contact_form_data = $contactForm->getData();
            
                $firstName = $contact_form_data['firstName'];
                $email = $contact_form_data['email'];
                $messageText = $contact_form_data['message'];
                
                $message = \Swift_Message::newInstance()
                        ->setSubject('New message from website | BankInfo.am')
                        ->setFrom(array('info@netbox.am' => 'BankInfo.am'))
                        ->setTo('info@bankinfo.am')
                        ->setBody($this->renderView('emails/contact_form.html.twig', array(
                            'firstName' => $firstName,
                            'email' => $email,
                            'messageText' => $messageText,
                        )), 'text/html');
                $this->get('mailer')->send($message);

                $contact_form_data = '';

                $this->addFlash(
                    'notice',
                    'Նամակն ուղարկված է'
                );
                
            } else {
                
                $this->addFlash(
                    'warning',
                    'Խնդրում ենք հաստատել, որ դուք ռոբոտ չեք'
                );
                
            }
            
            return $this->redirectToRoute('default_contact');
            
        }
        
        
        return $this->render('default/contact.html.twig', array(
            'page' => $page,
            'form' => $contactForm->createView()
        ));
        
    }
    
    /**
     * @Route("/{_locale}/credit-calculator", name="default_calculator_credit", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function calculatorCreditAction(Request $request)
    {
        
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();
        
        $repositoryPages = $manager->getRepository('AppBundle:Page');
        $page = $repositoryPages->findOneByPageSlug('credit-calculator');
        
        $page->setLocale($locale);
        $manager->refresh($page);
        
        return $this->render('default/calculator_credit.html.twig', array(
            'page' => $page
        ));
        
    }
    
    /**
     * @Route("/{_locale}/deposit-calculator", name="default_calculator_deposit", requirements={
     *         "_locale": "hy|en"
     *     })
     */
    public function calculatorDepositAction(Request $request)
    {
        
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();
        
        $repositoryPages = $manager->getRepository('AppBundle:Page');
        $page = $repositoryPages->findOneByPageSlug('deposit-calculator');
        
        $page->setLocale($locale);
        $manager->refresh($page);

        return $this->render('default/calculator_deposit.html.twig', array(
            'page' => $page
        ));
        
    }
    
}
