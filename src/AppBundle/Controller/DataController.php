<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Data;
use AppBundle\Entity\Bank;
use AppBundle\Entity\CbaRate;
use AppBundle\Entity\CreditCompany;
use AppBundle\Entity\Currency;

use Symfony\Component\Validator\Constraints\DateTime;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataController extends Controller {
    
    /**
     * Matches /maps exactly
     * 
     * @Route("/maps/{data}/{slug}.{_format}", name="data_maps", defaults={"_format": "json"}, requirements={"_format": "json|js"})
     */
    public function mapsAction($data, $slug){
        //  0 - Banks & Branches
        //  1 - ATMs
        //  2 - Credit Organizations
        //  3 - All
        //  4 - Show One branch
        //  5 - Show One Atm
        //  6 - Show One Credit Organizations
        //  /maps/0..4/all|slug.json

        $banks = array();
        $atms = array();
        $credits = array();


        if(isset($data) && $data >= 0 && $data <= 6){

            $repositoryBanks = $this->getDoctrine()->getRepository('AppBundle:Bank');
            $repositoryCreditCompanies = $this->getDoctrine()->getRepository('AppBundle:CreditCompany');
            $branchId=0;
            if($data == 0){

                 if($slug == 'all'){
                    $banks = $repositoryBanks->findAll();
                } else {
                    $banks = $repositoryBanks->findByBankSlug($slug);
                }

            } else if ($data == 1){

                if($slug == 'all'){
                    $atms = $repositoryBanks->findAll();
                } else {
                    $atms = $repositoryBanks->findByBankSlug($slug);
                }

            } else if ($data == 2){

                if($slug == 'all'){
                    $credits = $repositoryCreditCompanies->findAll();
                } else {
                    $credits = $repositoryCreditCompanies->findByCreditCompanySlug($slug);
                }

            } else if ($data == 3){

                $banks = $repositoryBanks->findAll();
                $atms = $banks;
                $credits = $repositoryCreditCompanies->findAll();

            }
            if($data == 4){
                $banks = $repositoryBanks->findAll();
                $branchId=$slug;
            }
           if ($data == 5){
               $atms = $repositoryBanks->findAll();
               $branchId=$slug;
            }
            if ($data == 6){
                $credits = $repositoryCreditCompanies->findAll();
                $branchId=$slug;
            }


            return $this->render('data/maps.html.twig', array(
                'banks' => $banks,
                'atms' => $atms,
                'credits' => $credits,
                'branchId'=>$branchId
            ));

        } else {

            return new JsonResponse(["error" => "Powerful you have become, the dark side I sense in you ..."]);

        }

    }

    /**
     * @Route(
     *  "/{_locale}/data/branches/{data}/{slug}", name="data_branches", 
     *  requirements={
     *      "_locale": "hy|en"
     *  },
     *  defaults={
     *      "_locale": "hy",
     *      "data": 0
     *  }
     *  )
     */
    public function getBranchesAction(Request $request, $data, $slug){
        
        //  0 - Bank Branches
        //  1 - Bank ATMs
        //  2 - Credit Company Branches
        
        //  /data/branches/0..3|slug
        
        $data = intval($data);
        
        $locale = $request->getLocale();
        $manager = $this->getDoctrine()->getManager();
        
        $bank = array();
        $creditCompany = array();
        
        $bankBranches = array();
        $bankAtms = array();
        $creditCompanyBranches = array();
        
        if(isset($data) && $data >= 0 && $data <= 3){
            
            $repositoryBanks = $manager->getRepository('AppBundle:Bank');
            $repositoryBankBranches = $manager->getRepository('AppBundle:BankBranch');
            $repositoryBankAtms = $manager->getRepository('AppBundle:BankAtm');
            $repositoryCreditCompanies = $manager->getRepository('AppBundle:CreditCompany');
            $repositoryCreditCompanyBranches = $manager->getRepository('AppBundle:CreditCompanyBranch');
            
            if($data == 0){
                
                $bank = $repositoryBanks->findOneByBankSlug($slug);
                $bankBranches = $repositoryBankBranches->findBy(['bank' => $bank],['bankBranchOrder' => 'ASC']);
                
                $bank->setLocale($locale);
                $manager->refresh($bank);
                
                foreach($bankBranches as $bankBranch){
                    $bankBranch->setLocale($locale);
                    $manager->refresh($bankBranch);
                }
                
            } else if ($data == 1){
                
                $bank = $repositoryBanks->findOneByBankSlug($slug);
                $bankAtms = $repositoryBankAtms->findBy(['bank' => $bank],['bankAtmOrder' => 'ASC']);

                $bank->setLocale($locale);
                $manager->refresh($bank);
                
                foreach($bankAtms as $bankAtm){
                    $bankAtm->setLocale($locale);
                    $manager->refresh($bankAtm);
                }
                
            } else if ($data == 2){
                
                $creditCompany = $repositoryCreditCompanies->findOneByCreditCompanySlug($slug);
                $creditCompanyBranches = $repositoryCreditCompanyBranches->findByCreditCompany($creditCompany);
                
                $creditCompany->setLocale($locale);
                $manager->refresh($creditCompany);
                
                foreach($creditCompanyBranches as $creditCompanyBranch){
                    $creditCompanyBranch->setLocale($locale);
                    $manager->refresh($creditCompanyBranch);
                }
                
            }
            return $this->render('data/branches.html.twig', array(
                'bank' => $bank,
                'creditCompany' => $creditCompany,
                'bankBranches' => $bankBranches,
                'bankAtms' => $bankAtms,
                'creditCompanyBranches' => $creditCompanyBranches
            ));
            
        } else {
            return new JsonResponse(["error" => "Powerful you have become, the dark side I sense in you ..."]);
        }
        
    }
    
    /**
     * Matches /data/cba-chart exactly
     * 
     * @Route(
     *  "/data/cba-chart/{year}/{currency}.{_format}", 
     *  name="data_cba_chart", 
     *  defaults={"_format": "json"}, 
     *  requirements={
     *      "_format": "json|js",
     *      "currency": "[a-z]{3}",
     *      "year": "[0-9]{4}"
     *  }
     * )
     */
    public function getCbaRatesChart($year, $currency){
        
        $json_rates = array();
        
        $yearCurrent = (int) date('Y');
        $yearNext = $yearCurrent + 1;
        $currencyDefault = 'USD';
        
        if(!is_null($currency)){ $currencyDefault = $currency; }
        if(!is_null($year)) { $yearCurrent = $year; $yearNext = $yearCurrent + 1; }
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT 
          cr.cbaRateRate,
          cr.cbaRateUpdateDate
        FROM
          AppBundle:CbaRate cr
        WHERE 
        cr.cbaRateUpdateDate > :dateto AND
        cr.cbaRateUpdateDate < :datefrom AND 
        cr.cbaRateCurrencyIso = :currencyid
        ORDER BY cr.cbaRateUpdateDate ASC')
                ->setParameter('datefrom', new \DateTime($yearNext.'-01-01 00:00:00'))
                ->setParameter('dateto', new \DateTime($yearCurrent.'-01-01 00:00:00'))
                ->setParameter('currencyid', $currencyDefault);
        $cba_rates = $query->getResult();
        
        foreach($cba_rates as $db_rate){
            
//            $updateDate = new \DateTime('now');
            $time = '';
            
            foreach($db_rate['cbaRateUpdateDate'] as $k => $v){ if($k == 'date') { $time = strtotime($v) * 1000; } }
            $json_rates[] = array(
                $time,
                $db_rate['cbaRateRate']
            );
            
        }
        
        if(!empty($json_rates)){
            return new JsonResponse($json_rates);
        } else {
            return new JsonResponse(["error" => "Powerful you have become, the dark side I sense in you ..."]);
        }
        
    }
    
    // *** Remote Data ***
    /**
     * Matches /data/quotes exactly
     * 
     * @Route("/data/quotes.{_format}", name="data_quotes", defaults={"_format": "json"}, requirements={"_format": "json|js"})
     */
    public function getQuotesAction(){

        $indexAddress = "http://www.rbc.ru/ajax/indicators";
        $indexContent = file_get_contents($indexAddress);

        $indexArray = json_decode($indexContent, true);

        unset($indexArray['cash']);
        unset($indexArray['currency']);

        for($i = 0; $i < count($indexArray['indices']); $i++){
            unset($indexArray['indices'][$i]['url']);
            unset($indexArray['indices'][$i]['time']);
            unset($indexArray['indices'][$i]['subname']);
            unset($indexArray['indices'][$i]['chg_abs']);
            unset($indexArray['indices'][$i]['chg_percent']);
            unset($indexArray['indices'][$i]['diff_high']);
            unset($indexArray['indices'][$i]['diff_low']);
            unset($indexArray['indices'][$i]['high']);
            unset($indexArray['indices'][$i]['low']);
            $indexArray['indices'][$i]['date'] = date('H.i', strtotime($indexArray['indices'][$i]['date'] . ' +1 hour'));
        }

        return new JsonResponse($indexArray);
    }
    
    
    /**
     * Matches /cba-data exactly
     * 
     * @Route("/cba-data/current.{_format}", name="cba_current", defaults={"_format": "json"}, requirements={"_format": "json|js"})
     */
    public function getCbaCurrentAction(){
        
        $data = new Data;
        $cba_current = $data->getCbaRatesCurrent();
        
        return new JsonResponse($cba_current);
        
    }
    
    /**
     * @Route("/cba-data/{date}/historical.{_format}", name="cba_historical", defaults={"_format": "json"}, requirements={"_format": "json|js"})
     */
    public function getCbaHistoricalAction($date){
        
        $data = new Data;
        $cba_historical = $data->getCbaRatesHistorical($date);
        
        return new JsonResponse($cba_historical);
        
    }
    
    /**
     * @Route("/cba-data/{dateFrom}/{dateTo}/{iso}", name="cba_range")
     */
    public function getCbaRangeAction($dateFrom, $dateTo, $iso = ""){
        
        $data = new Data;
        $cba_historical = $data->getCbaRatesRange($dateFrom, $dateTo, $iso);
        
        return new JsonResponse($cba_historical);
        
    }
    
    /**
     * @Route("/cba-data/iso-codes", name="cba_iso_codes")
     */
    public function getCbaIsoCodesAction($dateFrom, $dateTo, $iso = ""){
        
        $data = new Data;
        $cba_iso_codes = $data->getCbaIsoCodes();
        
        return new JsonResponse($cba_iso_codes);
        
    }
    
    /**
     * @Route("/data/bank-rates")
     */
    public function updateBankRates() {
        
        $data = new Data;
        
        $repositoryCurrencies = $this->getDoctrine()->getRepository('AppBundle:Currency');
        $currencies = $repositoryCurrencies->findAll();
        
        $repositoryBanks = $this->getDoctrine()->getRepository('AppBundle:Bank');
        $banks = $repositoryBanks->findAll();
        
        $dataResult = $data->getBankRates($banks, $currencies);
        
        return new JsonResponse($dataResult);
        
    }
    
    /**
     * @Route("/data/cba-latest-rates")
     */
    public function cbaRatesWidgetAction(){
        
        $cbaRatesArray = array();
        $dayBeforeDate = "";
        
        $repositoryCbaRates = $this->getDoctrine()->getRepository('AppBundle:CbaRate');
        $cbaRates = $repositoryCbaRates->findLatestCbaRates();

        foreach($cbaRates as $rate){

            $dayBeforeDate = $rate->getCbaRateUpdateDate();
            $cbaRatesArray[$rate->getCbaRateCurrencyIso()]['currency'] = $rate->getCbaRateCurrencyIso();
            $cbaRatesArray[$rate->getCbaRateCurrencyIso()]['rate'] = number_format($rate->getCbaRateRate(), 2);
            $cbaRatesArray[$rate->getCbaRateCurrencyIso()]['date'] = $rate->getCbaRateUpdateDate()->format('d.m.y H:i');
            
        }
        
        $cbaRatesDayBefore = $repositoryCbaRates->findLatestCbaRates($dayBeforeDate);
        
        foreach($cbaRatesDayBefore as $rate){
            $rate_difference = $cbaRatesArray[$rate->getCbaRateCurrencyIso()]['rate'] - $rate->getCbaRateRate();
            $cbaRatesArray[$rate->getCbaRateCurrencyIso()]['rate_difference'] = number_format($rate_difference, 3);
        }

        $currMapForWidget = ['USD','EUR','RUB','GBP'];
        $final = [];
        foreach ($cbaRatesArray as $key => $value){
            foreach ($currMapForWidget as $curr) {
                if ($key == $curr){
                    array_push($final,$value);
                }
            }
        }


        return $this->render('data/cba_widget.html.twig', array(
            'cbaRates' => $final
        ));
    }
}
