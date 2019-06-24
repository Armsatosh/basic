<?php

namespace AppBundle\Entity;

use Couchbase\Exception;
use Sunra\PhpSimple\HtmlDomParser;

class Data
{

    private $soapUrl = "http://api.cba.am/exchangerates.asmx";

    public function getCbaRatesCurrent()
    {

        $current_rates = array();

        // xml post structure
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
            '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">' .
            '<soap12:Body>' .
            '<ExchangeRatesLatest xmlns="http://www.cba.am/" />' .
            '</soap12:Body>' .
            '</soap12:Envelope>';

        $headers = array(
            "POST /exchangerates.asmx HTTP/1.1",
            "Host: api.cba.am",
            "Content-Type: application/soap+xml; charset=utf-8",
            "Content-length: " . strlen($xml_post_string)
        );

        $query = $this->initSoap($this->soapUrl, $xml_post_string, $headers);
        $rates = $query->ExchangeRatesLatestResponse->ExchangeRatesLatestResult->Rates->ExchangeRate;

        foreach ($rates as $rate) {

            $rate_array = (array)$rate;

            $current_rates['rates'][$rate_array['ISO']] = array(
                'iso' => $rate_array['ISO'],
                'rate' => $rate_array['Rate'],
                'amount' => $rate_array['Amount'],
                'diff' => $rate_array['Difference'],
            );

        }

        return $current_rates;

    }

    public function getCbaRatesHistorical($dateTime)
    { // 2000-01-01 (Y-m-d)

        $historical_rates = array();

        // xml post structure
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
            '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">' .
            '<soap12:Body>' .
            '<ExchangeRatesByDate xmlns="http://www.cba.am/">' .
            '<date>' . $dateTime . '</date>' .
            '</ExchangeRatesByDate>' .
            '</soap12:Body>' .
            '</soap12:Envelope>';

        $headers = array(
            "POST /exchangerates.asmx HTTP/1.1",
            "Host: api.cba.am",
            "Content-Type: application/soap+xml; charset=utf-8",
            "Content-length: " . strlen($xml_post_string)
        );

        $query = $this->initSoap($this->soapUrl, $xml_post_string, $headers);

        $date_currenct = (string)$query->ExchangeRatesByDateResponse->ExchangeRatesByDateResult->CurrentDate;
        $date_next_available = (string)$query->ExchangeRatesByDateResponse->ExchangeRatesByDateResult->NextAvailableDate;
        $date_previous_available = (string)$query->ExchangeRatesByDateResponse->ExchangeRatesByDateResult->PreviousAvailableDate;

        $historical_rates['date_currenct'] = $date_currenct;
        $historical_rates['date_next_available'] = $date_next_available;
        $historical_rates['date_previous_available'] = $date_previous_available;

        $rates = $query->ExchangeRatesByDateResponse->ExchangeRatesByDateResult->Rates->ExchangeRate;

        foreach ($rates as $rate) {

            $rate_array = (array)$rate;

            $historical_rates['rates'][$rate_array['ISO']] = array(
                'iso' => $rate_array['ISO'],
                'rate' => $rate_array['Rate'],
                'amount' => $rate_array['Amount'],
                'diff' => $rate_array['Difference'],
            );

        }

        return $historical_rates;

    }

    public function getCbaRatesRange($dateFrom, $dateTo, $isoCodes)
    { // 2000-01-01 (Y-m-d), ISO String

        $historical_rates = array();

        // xml post structure
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
            '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">' .
            '<soap12:Body>' .
            '<ExchangeRatesByDateRangeByISO xmlns="http://www.cba.am/">' .
            '<ISOCodes>' . $isoCodes . '</ISOCodes>' .
            '<DateFrom>' . $dateFrom . '</DateFrom>' .
            '<DateTo>' . $dateTo . '</DateTo>' .
            '</ExchangeRatesByDateRangeByISO>' .
            '</soap12:Body>' .
            '</soap12:Envelope>';

        $headers = array(
            "POST /exchangerates.asmx HTTP/1.1",
            "Host: api.cba.am",
            "Content-Type: application/soap+xml; charset=utf-8",
            "Content-Length: " . strlen($xml_post_string)
        );

        $query = $this->initSoap($this->soapUrl, $xml_post_string, $headers);

//        $date_currenct = (string) $query->ExchangeRatesByDateResponse->ExchangeRatesByDateResult->CurrentDate;
//        $date_next_available = (string) $query->ExchangeRatesByDateResponse->ExchangeRatesByDateResult->NextAvailableDate;
//        $date_previous_available = (string) $query->ExchangeRatesByDateResponse->ExchangeRatesByDateResult->PreviousAvailableDate;
//        
//        $historical_rates['date_currenct'] = $date_currenct;
//        $historical_rates['date_next_available'] = $date_next_available;
//        $historical_rates['date_previous_available'] = $date_previous_available;
//        
//        $rates = $query->ExchangeRatesByDateRangeByISOResponse->ExchangeRatesByDateRangeByISOResult->Rates->ExchangeRate;
        $rates = $query->ExchangeRatesByDateRangeByISOResponse->ExchangeRatesByDateRangeByISOResult;
//
//        foreach($rates as $rate) {
//            
//            $rate_array = (array) $rate;
//            
//            $historical_rates['rates'][$rate_array['ISO']] = array(
//                'iso' => $rate_array['ISO'],
//                'rate' => $rate_array['Rate'],
//                'amount' => $rate_array['Amount'],
//                'diff' => $rate_array['Difference'],
//            );
//            
//        }
//        $test = array($dateFrom, $dateTo, $isoCodes);
        return $rates;
//        return $historical_rates;

    }

    public function getCbaIsoCodes()
    {

        // xml post structure
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
            '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">' .
            '<soap12:Body>' .
            '<ISOCodes xmlns="http://www.cba.am/" />' .
            '</soap12:Body>' .
            '</soap12:Envelope>';

        $headers = array(
            "POST /exchangerates.asmx HTTP/1.1",
            "Host: api.cba.am",
            "Content-Type: application/soap+xml; charset=utf-8",
            "Content-length: " . strlen($xml_post_string)
        );

        $query = $this->initSoap($this->soapUrl, $xml_post_string, $headers);
        $codes = $query->ISOCodesResponse->ISOCodesResult->string;

        return $codes;

    }

    private function initSoap($soapUrl, $xml_post_string, $headers)
    {

        $url = $soapUrl;

        // PHP cURL  for https connection with auth
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch);
        curl_close($ch);

        // converting
        $response1 = str_replace("<soap:Body>", "", $response);
        $response2 = str_replace("</soap:Body>", "", $response1);

        // convertingc to XML
        $parser = simplexml_load_string($response2);

        return $parser;

    }

    // Bank Rates
    public function getBankRates($banks, $currencies)
    {

        $data = array();
        $bankData = array();

        foreach ($banks as $bank) {
            $bankData[$bank->getBankSlug()]['bankId'] = $bank->getBankId();
            $bankData[$bank->getBankSlug()]['bankRateLink'] = $bank->getBankRateLink();
        }




        /*** WORK + ***/
        $vtb = $this->getVtbRates($bankData['vtb']['bankRateLink'], $currencies);


        /*** WORK + ***/
        $unibank = $this->getUnibankRates($bankData['unibank']['bankRateLink'], $currencies);

        /*** WORK + CHANGE LINK - ***/
        $ararat = $this->getAraratRates('https://www.araratbank.am/en/', $currencies);


        /*** WORK + ***/
        $acba = $this->getAcbaRates($bankData['acba-bank']['bankRateLink'], $currencies);

        /*** WORK + ***/
        $ameria = $this->getAmeriaRates($bankData['ameria-bank']['bankRateLink'], $currencies);

        /*** WORK +  CHANGE LINK - ***/
        $anelik = $this->getAnelikRates('http://www.anelik.am/en/', $currencies);


        //TODO:het berel
//        /*** WORK + CHANGE LINK - ***/
        // $ararat = $this->getAraratRates('https://www.araratbank.am/en/home.html', $currencies);

        /*** WORK +  CHANGE LINK - ***/
        $ardshin = $this->getArdshinRates('https://www.ardshinbank.am/en/content/rating-bank', $currencies);


        /*** WORK + CHANGE LINK - ***/
        $armBusiness = $this->getArmBusinessRates('http://www.armbusinessbank.am/en/', $currencies);

        /*** WORK + ***/
        $armEconom = $this->getArmEconomRates($bankData['armeconom-bank']['bankRateLink'], $currencies);

        /*** WORK + ***/
        $armSwiss = $this->getArmSwissRates($bankData['armswiss-bank']['bankRateLink'], $currencies);

        /*** WORK + ***/
        $artsakh = $this->getArtsakhRates($bankData['artsakh-bank']['bankRateLink'], $currencies);

        /*** WORK + ***/
        $byblos = $this->getByblosRates($bankData['byblos-bank']['bankRateLink'], $currencies);

        /*** WORK + ***/
        $converse = $this->getConverseRates($bankData['converse-bank']['bankRateLink'], $currencies);

        /*** HSBC Placeholder ***/
        $hsbc = $this->getHsbcRates('http://www.rate.am/en/armenian-dram-exchange-rates/banks/cash', $currencies);

        /*** ACCESS DENIED ***/
        $ineco = $this->getInecoRates($bankData['inecobank']['bankRateLink'], $currencies);

        /*** WORK + ***/
        $melalt = $this->getMellatRates($bankData['mellat-bank']['bankRateLink'], $currencies);
           // dump($melalt );

        /*** WORK + CHANGE LINK - ***/
        $evoka = $this->getEvokaRates('https://www.evocabank.am/home.html', $currencies);

//        /*** WORK + ***/
//        $unibank = $this->getUnibankRates($bankData['unibank']['bankRateLink'], $currencies);

        if (isset($acba))
            $data[$bankData['acba-bank']['bankId']] = $acba;


        if (isset($ameria))
            $data[$bankData['ameria-bank']['bankId']] = $ameria;

        if (isset($anelik))
            $data[$bankData['anelik-bank']['bankId']] = $anelik;

        if (isset($ararat))
            $data[$bankData['ararat-bank']['bankId']] = $ararat;

        if (isset($ardshin))
            $data[$bankData['ardshininvest-bank']['bankId']] = $ardshin;

        if (isset($armBusiness))
            $data[$bankData['armbusiness-bank']['bankId']] = $armBusiness;

        if (isset($armEconom))
            $data[$bankData['armeconom-bank']['bankId']] = $armEconom;

        if (isset($armSwiss))
            $data[$bankData['armswiss-bank']['bankId']] = $armSwiss;

        if (isset($artsakh))
            $data[$bankData['artsakh-bank']['bankId']] = $artsakh;

        if (isset($byblos))
            $data[$bankData['byblos-bank']['bankId']] = $byblos;

        if (isset($converse))
            $data[$bankData['converse-bank']['bankId']] = $converse;

        if (isset($hsbc))
            $data[$bankData['hsbc']['bankId']] = $hsbc;

        if (isset($ineco))
            $data[$bankData['inecobank']['bankId']] = $ineco;

        if (isset($melalt))
            $data[$bankData['mellat-bank']['bankId']] = $melalt;

        if (isset($evoka))
            $data[$bankData['prometey-bank']['bankId']] = $evoka;

        if (isset($unibank))
            $data[$bankData['unibank']['bankId']] = $unibank;

        if (isset($vtb))
            $data[$bankData['vtb']['bankId']] = $vtb;


        return $data;
    }




    /*** cash and non cash + Done Optimized ***/
    private function getAcbaRates($bankRateLink, $currencies)
    {
        try {
            $data = array();
            $xmlFile = file_get_contents($bankRateLink);
            $xmlParser = new \SimpleXMLElement($xmlFile);
            $buy = "buy";
            $sell = "sell";
            $buycashrate = "buycashrate";
            $sellcashrate = "sellcashrate";

            for($i = 0 ; $i < 2 ; $i++) {


                foreach ($xmlParser->RATE as $key => $curency) {

                    $currentCurrencyId = null;

                    $currentCurrency = null;
                    $currentBuy = null;
                    $currentSell = null;

                    foreach ($curency->attributes() as $attribName => $attribValue) {

                        $value = (string)$attribValue;

                        if ($attribName == "currency") {
                            $currentCurrency = $value;
                        }
                        if ($attribName == $buycashrate) {
                            $currentBuy = $value;
                        }
                        if ($attribName == $sellcashrate) {
                            $currentSell = $value;
                        }

                    }
                    if ($currentCurrency == "RUR") {
                        $currentCurrency = "RUB";
                    }

                    foreach ($currencies as $curerncy) {
                        if ($currentCurrency == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }

                    if ($currentCurrencyId) {
                        $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $currentBuy));
                        $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $currentSell));
                    }

                }

                $buy = "buyNonCash";
                $sell = "sellNonCash";
                $buycashrate = "buy";
                $sellcashrate = "sell";
            }

            return $data;
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash + Done Optimized ***/
    private function getAmeriaRates($bankRateLink, $currencies)
    {
        try {

            $data = array();
            $xmlFile = file_get_contents($bankRateLink);

            $xmlParser = new \SimpleXMLElement($xmlFile);
            $htmlDataContainer = $xmlParser->channel->item->description;

            $html = HtmlDomParser::str_get_html($htmlDataContainer);
            $buy = "buy";
            $sell = "sell";

            for($i = 0 ; $i < 2 ; $i ++) {

                foreach ($html->find('tr') as $element) {

                    $currentCurrencyId = null;

                    $col1 = trim($element->find('td')[0]->plaintext);
                    $col2 = trim($element->find('td')[1]->plaintext);
                    $col3 = trim($element->find('td')[2]->plaintext);

                    if ($col1 == "RUR") {
                        $col1 = "RUB";
                    }

                    foreach ($currencies as $curerncy) {

                        if ($col1 == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }

                    if ($currentCurrencyId !== null) {
                        $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $col2));
                        $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $col3));
                    }

                }
                $xmlFile = file_get_contents("http://www.ameriabank.am/rssch.aspx?type=1");
                $xmlParser = new \SimpleXMLElement($xmlFile);
                $htmlDataContainer = $xmlParser->channel->item->description;
                $html = HtmlDomParser::str_get_html($htmlDataContainer);
                $buy = "buyNonCash";
                $sell = "sellNonCash";
            }

            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash + Done Optimized ***/
    private function getAnelikRates($bankRateLink, $currencies)
    {

        try {

            $data = array();
            $content = $this->bankCurlInit($bankRateLink);


            $html = HtmlDomParser::str_get_html($content);
            $searchResultsBlocks = $html->find('div.exchange_type_block');


            $currencyMapping = array('USD', 'EUR', 'GBP', 'RUB','CHF','TEST');
            $cc = 0;
            $index = 0;
            $buy = "buy";
            $sell = "sell";

            foreach($searchResultsBlocks as $searchResults) {

                foreach ($searchResults->find('ul') as $searchResultsItems) {

                    foreach ($searchResultsItems->find('li') as $element) {

                        $currentCurrencyId = null;

                        $currentElement = substr(trim($element->plaintext), 0);

                        $elementRework = str_replace(', ', '-', $currentElement);
                        $elementRework = str_replace(' ', '-', $elementRework);
                        $currentRates = explode("-", $elementRework);


                        foreach ($currencies as $curerncy) {

                            if ($currencyMapping[$cc] == $curerncy->getCurrencySymbol()) {
                                $currentCurrencyId = $curerncy->getCurrencyId();
                            }
                        }

                        if ($currentCurrencyId !== null) {
                            if (!empty($currentRates[2])) {
                                $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $currentRates[1]));
                                $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $currentRates[2]));
                                $cc++;
                            }
                        }

                    }
                }
                $cc = 0;
                $index++;
                if($index == 1){
                    $buy = "buyNonCash";
                    $sell = "sellNonCash";
                }
                if($index == 2){
                    break;
                }
            }
            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash + Done Optimized ***/
    private function getArdshinRates($bankRateLink, $currencies)
    {

        try {

            $data = array();
            $content = $this->bankCurlInit($bankRateLink);

            $html = HtmlDomParser::str_get_html($content);
            $searchResultsTables = $html->find('table.tg');
            $index = 0;
            $buy = "buy";
            $sell = "sell";

            foreach($searchResultsTables as $searchResults) {

                foreach ($searchResults->find('tr') as $element) {

                    $currentCurrencyId = null;

                    $col1 = trim(@$element->find('td')[0]->plaintext);
                    $col2 = trim(@$element->find('td')[1]->plaintext);
                    $col3 = trim(@$element->find('td')[2]->plaintext);

                    foreach ($currencies as $curerncy) {
                        if ($col1 == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }

                    if ($currentCurrencyId !== null) {
                        $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $col2));
                        $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $col3));
                    }

                }

                $index++;
                if($index == 1){
                    $buy = "buyNonCash";
                    $sell = "sellNonCash";
                }
                if($index == 2){
                    break;
                }
            }

            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash + Done Optimized ***/
    private function getArmBusinessRates($bankRateLink, $currencies)
    {
        try {
            $data = array();
            $htmlString = file_get_contents($bankRateLink);
            $html = HtmlDomParser::str_get_html($htmlString);
            $currencyMapping = array('USD', 'EUR', 'RUB', 'GBP', 'CHF');
            $cc = 0;
            $tabIndex = 1;
            $buy = "buy";
            $sell = "sell";
            for($i = 0 ; $i < 2; $i ++) {

                $searchResults = $html->find('.border_tab', $tabIndex);

                foreach ($searchResults->find('tr') as $element) {

                    $currentCurrencyId = null;

                    $col1 = trim(strip_tags($element->find('td')[1]->plaintext));
                    $col2 = trim(strip_tags($element->find('td')[3]->plaintext));


                    foreach ($currencies as $curerncy) {
                        if ($currencyMapping[$cc] == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }

                    $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $col1));
                    $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $col2));

                    $cc++;

                }
                $cc = 0;$tabIndex = 3;
                $buy = "buyNonCash";
                $sell = "sellNonCash";
            }

            return $data;
        }catch (\Exception $e) {

            $data = [];
            return $data;
        }
    }

    /*** cash and non cash + Done Optimized ***/
    private function getArmEconomRates($bankRateLink, $currencies)
    {

        try {
            $data = array();

            $content = $this->bankCurlInit($bankRateLink);
            $html = HtmlDomParser::str_get_html($content);


            $searchResultsBloks = $html->find('table.exchange_table');
            $index = 0;
            $buy = "buy";
            $sell = "sell";

            foreach($searchResultsBloks as $searchResults) {


                foreach ($searchResults->find('tr') as $element) {

                    $currentCurrencyId = null;

                    $col1 = trim(@$element->find('td')[0]->plaintext);
                    $col2 = trim(@$element->find('td')[1]->plaintext);
                    $col3 = trim(@$element->find('td')[2]->plaintext);

                    if ($col1 == 'RUR') {
                        $col1 = 'RUB';
                    }

                    foreach ($currencies as $curerncy) {
                        if ($col1 == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }

                    if ($currentCurrencyId !== null) {
                        $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $col2));
                        $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $col3));
                    }

                }

                $index++;
                if($index == 1){
                    $buy = "buyNonCash";
                    $sell = "sellNonCash";
                }
                if($index == 2){
                    break;
                }

            }

            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash + Done Optimized ***/
    private function getArmSwissRates($bankRateLink, $currencies)
    {

        try {
            $data = array();

            $dataArray = json_decode(file_get_contents($bankRateLink), true);

            $BID_cash = "BID_cash";
            $OFFER_cash = "OFFER_cash";
            $buy = "buy";
            $sell = "sell";


            for($i = 0 ; $i < 2; $i++) {

                foreach ($dataArray['lmasbrate'] as $rate) {

                    $col1 = $rate['ISO'];
                    $col2 = $rate[$BID_cash];
                    $col3 = $rate[$OFFER_cash];

                    if ($col1 == "JPY 10") {
                        $col1 = "JPY";
                    }

                    foreach ($currencies as $curerncy) {
                        if ($col1 == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }

                    if ($currentCurrencyId !== null) {
                        $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $col2));
                        $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $col3));
                    }
                }

                $BID_cash = "BID";
                $OFFER_cash = "OFFER";
                $buy = "buyNonCash";
                $sell = "sellNonCash";
            }

            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }


    /*** second stage ***/

    /*** cash and non cash Done Optimized ***/
    private function getArtsakhRates($bankRateLink, $currencies)
    {

        try {
            $data = array();
            $content = $this->bankCurlInit($bankRateLink);

            $html = HtmlDomParser::str_get_html($content);
            $selectorName = "table#cash_rate tr";
            $buy = "buy";
            $sell = "sell";

            for($i = 0 ; $i < 2; $i ++){

                foreach ($html->find($selectorName) as $element) {

                    $currentCurrencyId = null;

                    $col1 = trim(@$element->find('td')[0]->plaintext);
                    $col2 = trim(@$element->find('td')[1]->plaintext);
                    $col3 = trim(@$element->find('td')[2]->plaintext);

                    foreach ($currencies as $curerncy) {
                        if ($col1 == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }

                    if ($currentCurrencyId !== null) {
                        $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $col2));
                        $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $col3));
                    }

                }

                $buy = "buyNonCash";
                $sell = "sellNonCash";
                $selectorName = "table#clearing_rate tr";
            }

            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }

    }

    /*** cash and non cash + Done Optimized ***/
    private function getUnibankRates($bankRateLink, $currencies)
    {

        try {
            $data = array();
            $content = $this->bankCurlInit($bankRateLink);

            $html = HtmlDomParser::str_get_html($content);
            $buy = "buy";
            $sell = "sell";

            $currencyCash = $html->find('div.pane__body');

            $index = 0;
            $selectorIndex = 1;

            foreach ($currencyCash as $cashC) {
                if($index == 2)break;

                $ul = $cashC->find('ul',$selectorIndex);
                $itemList = $ul->find('li');

                for ($i = 0 ; $i < count($itemList); $i+=3){

                    $col1 = $itemList[$i]->find('span')[0]->plaintext;
                    $col2 = $itemList[$i+1]->find('span')[0]->plaintext;
                    $col3 = $itemList[$i+2]->find('span')[0]->plaintext;

                    $col1 = str_replace(' ','',$col1);
                    $col2 = str_replace(' ','',$col2);
                    $col3 = str_replace(' ','',$col3);

                    foreach ($currencies as $curerncy) {
                        if ($col1 == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }

                    if ($currentCurrencyId !== null) {
                        $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $col2));
                        $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $col3));
                    }

                }

                $index++;
                $selectorIndex--;

                $buy = "buyNonCash";
                $sell = "sellNonCash";
            }


            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }

    }

    /*** second stage ***/

    

    /*** cash and non cash + Done Optimized ***/
    private function getVtbRates($bankRateLink, $currencies)
    {

        try {
            $data = array();
            $content = $this->bankCurlInit($bankRateLink);

            $html = HtmlDomParser::str_get_html($content);
            $searchResults = $html->find('table.tbl-01', 0);

            $fstIndex = 3;
            $secIndex = 4;
            $buy = "buy";
            $sell = "sell";

            for ($i = 0 ; $i < 2 ;$i ++) {

                foreach ($searchResults->find('tr') as $element) {

                    $currentCurrencyId = null;

                    $col1 = trim(@$element->find('td')[1]->plaintext);
                    $col1 = str_replace("/AMD", "", strip_tags($col1));

                    $col2 = trim(@$element->find('td')[$fstIndex]->plaintext);
                    $col3 = trim(@$element->find('td')[$secIndex]->plaintext);

                    if($col1 == "GBP*") {
                        $col1 = "GBP";
                    }

                    foreach ($currencies as $curerncy) {
                        if ($col1 == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }

                    if ($currentCurrencyId !== null) {
                        $data[$currentCurrencyId][$buy] = (float)floatval(str_replace(",", ".", $col2));
                        $data[$currentCurrencyId][$sell] = (float)floatval(str_replace(",", ".", $col3));
                    }
                }

                $fstIndex = 5;
                $secIndex = 6;
                $buy = "buyNonCash";
                $sell = "sellNonCash";
            }

            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash + Done ***/
    private function getConverseRates($bankRateLink, $currencies)
    {

        try {
            $data = array();


            $content = $this->bankCurlInit($bankRateLink);
            //$content = file_get_contents($bankRateLink);

            $html = HtmlDomParser::str_get_html($content);



            foreach ($html->find('table.mon_exchange tr') as $element) {

                $currentCurrencyId = null;

                $col1 = trim(@$element->find('td')[0]->plaintext);
                $col2 = trim(@$element->find('td')[1]->plaintext);
                $col3 = trim(@$element->find('td')[2]->plaintext);

                foreach ($currencies as $curerncy) {
                    if ($col1 == $curerncy->getCurrencySymbol()) {
                        $currentCurrencyId = $curerncy->getCurrencyId();
                    }
                }

                if ($currentCurrencyId !== null) {
                    $data[$currentCurrencyId]['buy'] = (float)floatval(str_replace(",", ".", $col2));
                    $data[$currentCurrencyId]['sell'] = (float)floatval(str_replace(",", ".", $col3));
                }

            }

            $currencyTable = $html->find('div#main_static_content',0)->find('table',0);
            foreach ($currencyTable->find('tr') as $element) {
                $currentCurrencyId = null;
                $col1 = trim(@$element->find('td')[0]->plaintext);
                $col2 = trim(@$element->find('td')[5]->plaintext);
                $col3 = trim(@$element->find('td')[6]->plaintext);

                foreach ($currencies as $curerncy) {
                    if ($col1 == $curerncy->getCurrencySymbol()) {
                        $currentCurrencyId = $curerncy->getCurrencyId();
                    }
                }

                if ($currentCurrencyId !== null) {
                    $data[$currentCurrencyId]['buyNonCash'] = (float)floatval(str_replace(",", ".", $col2));
                    $data[$currentCurrencyId]['sellNonCash'] = (float)floatval(str_replace(",", ".", $col3));
                }

            }
            
            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash + Done ***/
    private function getHsbcRates($bankRateLink, $currencies)
    {

        try {
            $data = array();
            $html1 = file_get_contents($bankRateLink);
            $html = HtmlDomParser::str_get_html($html1);
            $dataTable = $html->find('table.rb tr');

            $currencyMapping = array('USD', 'RUB', 'EUR', 'GBP');

            foreach ($dataTable as $element) {
                $col2 = trim(@$element->find('td')[1]->plaintext);

                if ($col2 == "HSBC Bank Armenia") {
                    $col6 = trim(@$element->find('td')[5]->plaintext);
                    $col7 = trim(@$element->find('td')[6]->plaintext);
                    $col8 = trim(@$element->find('td')[7]->plaintext);
                    $col9 = trim(@$element->find('td')[8]->plaintext);
                    $col10 = trim(@$element->find('td')[9]->plaintext);
                    $col11 = trim(@$element->find('td')[10]->plaintext);
                    $col12 = trim(@$element->find('td')[11]->plaintext);
                    $col13 = trim(@$element->find('td')[12]->plaintext);
                    $hsbcCurrency = $col6 . "/" . $col7 . "/" . $col8 . "/" . $col9 . "/" . $col10 . "/" . $col11 . "/" . $col12 . "/" . $col13;
                    $arrayOfCurrency = explode('/', $hsbcCurrency);
                    $currentCurrencyId = array();
                    $index = 0;
                    foreach ($currencies as $curerncy) {
                        foreach ($currencyMapping as $currentCurrency) {
                            if ($currentCurrency == $curerncy->getCurrencySymbol()) {
                                array_push($currentCurrencyId, $curerncy->getCurrencyId());
                            }
                        }
                    }
                    for ($i = 0; $i < count($currentCurrencyId); $i++) {
                        $data[$currentCurrencyId[$i]]['buy'] = (float)floatval(str_replace(",", ".", $arrayOfCurrency[$index]));
                        $data[$currentCurrencyId[$i]]['sell'] = (float)floatval(str_replace(",", ".", $arrayOfCurrency[$index + 1]));
                        $index += 2;
                    }


                    break;
                }
            }

            $bankRateLink = "http://www.rate.am/en/armenian-dram-exchange-rates/banks/non-cash";
            $html1 = file_get_contents($bankRateLink);
            $html = HtmlDomParser::str_get_html($html1);
            $dataTable = $html->find('table.rb tr');
            $currencyMapping = array('USD', 'RUB', 'EUR', 'GBP');

            foreach ($dataTable as $element) {
                $col2 = trim(@$element->find('td')[1]->plaintext);

                if ($col2 == "HSBC Bank Armenia") {
                    $col6 = trim(@$element->find('td')[5]->plaintext);
                    $col7 = trim(@$element->find('td')[6]->plaintext);
                    $col8 = trim(@$element->find('td')[7]->plaintext);
                    $col9 = trim(@$element->find('td')[8]->plaintext);
                    $col10 = trim(@$element->find('td')[9]->plaintext);
                    $col11 = trim(@$element->find('td')[10]->plaintext);
                    $col12 = trim(@$element->find('td')[11]->plaintext);
                    $col13 = trim(@$element->find('td')[12]->plaintext);


                    $hsbcCurrency = $col6 . "/" . $col7 . "/" . $col8 . "/" . $col9 . "/" . $col10 . "/" . $col11 . "/" . $col12 . "/" . $col13;
                    $arrayOfCurrency = explode('/', $hsbcCurrency);
                    $currentCurrencyId = array();
                    $index = 0;
                    foreach ($currencies as $curerncy) {
                        foreach ($currencyMapping as $currentCurrency) {
                            if ($currentCurrency == $curerncy->getCurrencySymbol()) {
                                array_push($currentCurrencyId, $curerncy->getCurrencyId());
                            }
                        }
                    }
                    for ($i = 0; $i < count($currentCurrencyId); $i++) {
                        $data[$currentCurrencyId[$i]]['buyNonCash'] = (float)floatval(str_replace(",", ".", $arrayOfCurrency[$index]));
                        $data[$currentCurrencyId[$i]]['sellNonCash'] = (float)floatval(str_replace(",", ".", $arrayOfCurrency[$index + 1]));
                        $index += 2;
                    }
                    break;
                }
            }

            $buffer = $data[2];
            $data[2] = $data[10];
            $data[10] = $buffer;

            $buffer = $data[2];
            $data[2] = $data[51];
            $data[51] = $buffer;


            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash + Done ***/
    private function getEvokaRates($bankRateLink, $currencies)
    {

        try {
            $data = array();
            $content = $this->bankCurlInit($bankRateLink);

            $html = HtmlDomParser::str_get_html($content);

            $searchResults = $html->find('table.exchange_table', 0);

            foreach ($searchResults->find('tr') as $element) {

                $currentCurrencyId = null;

                $col1 = trim(@$element->find('td')[0]->plaintext);
                $col2 = trim(@$element->find('td')[1]->plaintext);
                $col3 = trim(@$element->find('td')[2]->plaintext);

                foreach ($currencies as $curerncy) {
                    if ($col1 == $curerncy->getCurrencySymbol()) {
                        $currentCurrencyId = $curerncy->getCurrencyId();
                    }
                }

                if ($currentCurrencyId !== null) {
                    $data[$currentCurrencyId]['buy'] = (float)floatval(str_replace(",", ".", $col2));
                    $data[$currentCurrencyId]['sell'] = (float)floatval(str_replace(",", ".", $col3));
                }

            }


            $searchResults = $html->find('table.exchange_table', 1);

            foreach ($searchResults->find('tr') as $element) {

                $currentCurrencyId = null;

                $col1 = trim(@$element->find('td')[0]->plaintext);
                $col2 = trim(@$element->find('td')[1]->plaintext);
                $col3 = trim(@$element->find('td')[2]->plaintext);

                foreach ($currencies as $curerncy) {
                    if ($col1 == $curerncy->getCurrencySymbol()) {
                        $currentCurrencyId = $curerncy->getCurrencyId();
                    }
                }

                if ($currentCurrencyId !== null) {
                    $data[$currentCurrencyId]['buyNonCash'] = (float)floatval(str_replace(",", ".", $col2));
                    $data[$currentCurrencyId]['sellNonCash'] = (float)floatval(str_replace(",", ".", $col3));
                }

            }

            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }


    /*** cash and non cash - Failed  SAME AS CASH  ***/
    private function getByblosRates($bankRateLink, $currencies)
    {

        try {
            $data = array();
            $content = $this->bankCurlInit($bankRateLink);

            $html = HtmlDomParser::str_get_html($content);

            $searchResults = $html->find('table.rate_table', 0);


            foreach($searchResults->find('tr') as $element) {

                $currentCurrencyId = null;

                $col1 = trim(@$element->find('td')[0]->plaintext);
                $col2 = trim(@$element->find('td')[1]->plaintext);
                $col3 = trim(@$element->find('td')[2]->plaintext);

                foreach($currencies as $curerncy){ if($col1 == $curerncy->getCurrencySymbol()){ $currentCurrencyId = $curerncy->getCurrencyId(); } }

                if ($currentCurrencyId !== null) {
                    $data[$currentCurrencyId]['buy'] = (float) floatval(str_replace(",", ".", $col2));
                    $data[$currentCurrencyId]['sell'] = (float) floatval(str_replace(",", ".", $col3));

                    $data[$currentCurrencyId]['buyNonCash'] = (float) floatval(str_replace(",", ".", $col2));
                    $data[$currentCurrencyId]['sellNonCash'] = (float) floatval(str_replace(",", ".", $col3));
                }

            }

            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash - Failed  SAME AS CASH  ***/
    private function getInecoRates($bankRateLink, $currencies)
    {
        try {
            $data = array();
            $html1 = file_get_contents($bankRateLink);

            $html = HtmlDomParser::str_get_html($html1);

            foreach ($html->find('tr') as $element) {

                $currentCurrencyId = null;

                $col1 = trim(@$element->find('td')[0]->plaintext);
                $col2 = trim(@$element->find('td')[1]->plaintext);
                $col3 = trim(@$element->find('td')[2]->plaintext);

                if ($col1 == "RUR") {
                    $col1 = "RUB";
                }

                foreach ($currencies as $curerncy) {
                    if ($col1 == $curerncy->getCurrencySymbol()) {
                        $currentCurrencyId = $curerncy->getCurrencyId();
                    }
                }

                if ($currentCurrencyId !== null) {
                    $data[$currentCurrencyId]['buy'] = (float)floatval(str_replace(",", ".", $col2));
                    $data[$currentCurrencyId]['sell'] = (float)floatval(str_replace(",", ".", $col3));

                    $data[$currentCurrencyId]['buyNonCash'] = (float)floatval(str_replace(",", ".", $col2));
                    $data[$currentCurrencyId]['sellNonCash'] = (float)floatval(str_replace(",", ".", $col3));
                }

            }

            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash - Failed  SAME AS CASH  ***/
    private function getMellatRates($bankRateLink, $currencies)
    {

        try {

            $data = array();
            $content = $this->bankCurlInit($bankRateLink);

            $html = HtmlDomParser::str_get_html($content);
            $searchResults = $html->find('table.rateTablo', 0);

            $currencyMapping = array('EUR', 'RUB' ,'USD');
            $cc = 0;
            $rc = 0;


            foreach ($searchResults->find('tr') as $element) {
                if ($rc !== 0) {
                    $currentCurrencyId = null;
                    $col2 = trim(strip_tags($element->find('td')[1]->plaintext));
                    $col3 = trim(strip_tags($element->find('td')[2]->plaintext));

                    foreach ($currencies as $curerncy) {
                        if ($currencyMapping[$cc] == $curerncy->getCurrencySymbol()) {
                            $currentCurrencyId = $curerncy->getCurrencyId();
                        }
                    }
                    if ($currentCurrencyId !== null) {
                        $data[$currentCurrencyId]['buy'] = (float)floatval(str_replace(",", ".", $col2));
                        $data[$currentCurrencyId]['sell'] = (float)floatval(str_replace(",", ".", $col3));

                        $data[$currentCurrencyId]['buyNonCash'] = (float)floatval(str_replace(",", ".", $col2));
                        $data[$currentCurrencyId]['sellNonCash'] = (float)floatval(str_replace(",", ".", $col3));
                    }
                    $cc++;
                }
                $rc++;
            }
            return $data;

        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    /*** cash and non cash - Failed  SAME AS CASH ***/
    private function getAraratRates($bankRateLink, $currencies)
    {

        try {


            $data = array();

            $htmlString = file_get_contents($bankRateLink, false, stream_context_create(array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                )
            )));


            $html = HtmlDomParser::str_get_html($htmlString);

            $currencyMapping = array('USD', 'EUR', 'RUB', 'GBP', 'CHF', 'GEL', 'CAD', 'AUD');
            $cc = 0;
            $rc = 0;

            $searchResults = $html->find('table.exchange__table');
            $indexx = 0;

            foreach ($searchResults as $table) {

                if($indexx  == 2)break;

                foreach ($table->find('tr') as $element) {

                    $currentCurrencyId = null;

                    if ($rc !== 0) {

                        $col1 = trim(strip_tags($element->find('td')[0]->plaintext));
                        $col2 = trim(strip_tags($element->find('td')[1]->plaintext));

                        $col1 = explode(' ',$col1);
                        $col1 = $col1[count($col1)-1];


                        foreach ($currencies as $curerncy) {
                            if ($currencyMapping[$cc] == $curerncy->getCurrencySymbol()) {
                                $currentCurrencyId = $curerncy->getCurrencyId();
                            }
                        }


                        if($indexx == 0) {
                            $data[$currentCurrencyId]['buyNonCash'] = (float)floatval(str_replace(",", ".", $col1));
                            $data[$currentCurrencyId]['sellNonCash'] = (float)floatval(str_replace(",", ".", $col2));
                        }

                        if($indexx == 1) {
                            $data[$currentCurrencyId]['buy'] = (float)floatval(str_replace(",", ".", $col1));
                            $data[$currentCurrencyId]['sell'] = (float)floatval(str_replace(",", ".", $col2));
                        }

                        $cc++;

                    }

                    $rc++;
                }

                $indexx++;
                $rc = 0;
                $cc = 0;
            }


            return $data;
        }catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }


    private function bankCurlInit($bankRateLink) {

        $ch= curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, $bankRateLink);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_VERBOSE,1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.76 Safari/537.36');
        curl_setopt ($ch, CURLOPT_REFERER, 'https://www.google.com');  //just a fake referer
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 20);

        $content = curl_exec($ch);



        curl_close($ch);

        return $content;
    }

}
