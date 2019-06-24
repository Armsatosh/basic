<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use AppBundle\Entity\Data;
use AppBundle\Entity\CbaRate;

class MigrateCbaRatesCommand extends ContainerAwareCommand
{
    
    protected $nextAvailableDay = null;


    protected function configure()
    {
        
        $this
            // the name of the command (the part after "app/console")
            ->setName('rates:get-cba-historical-rates')

            // the short description shown while running "php app/console list"
            ->setDescription('Get historical rates from central bank')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command activates code for parsing rates from central bank of Armenia')
                
            ->addArgument('dateFrom', InputArgument::OPTIONAL, 'Date From. Format: YYYY-MM-DD /Optional; Sets To Today Id Not Set/')
            ->addArgument('dateTo', InputArgument::OPTIONAL, 'Date To. Format: YYYY-MM-DD /Optional/')
        ;
        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $file = "/var/www/www-root/data/www/www.bankinfo.am/app/logs/rates_cba.log";
        $dateFrom = $input->getArgument('dateFrom');
        $dateTo = $input->getArgument('dateTo');
        
        if(empty($dateFrom)){
            $dateFrom = date("Y-m-d");
            $dateTo = $dateFrom;
        }
        
        $doctrine = $this->getContainer()->get('doctrine');
        
        $data = new Data;
        $repositoryCbaRates = $doctrine->getRepository('AppBundle:CbaRate');
        
        
        $output->writeln([
            'Date From: '.$dateFrom,
            'Date To: '.$dateTo,
            '',
        ]);
        
        $this->nextAvailableDay = $dateFrom;
        
        while($this->nextAvailableDay !== null){
            
            $historicalRates = $data->getCbaRatesHistorical($this->nextAvailableDay);
            
            $output->writeln([$this->nextAvailableDay,]);
            
            $currentDay = date('Y-m-d', strtotime($historicalRates['date_currenct']));
            $nextDay = date('Y-m-d', strtotime($historicalRates['date_next_available']));
            $queryDate = new \DateTime($historicalRates['date_currenct']);
            
            foreach($historicalRates['rates'] as $rate){
                
                $dateNow = new \DateTime();
                
                $amount = $rate['amount'];
                $currency = (string) $rate['iso'];
                $dataRate = floatval($rate['rate']);
                
                
                $rate = $repositoryCbaRates->findOneBy(
                        array(
                            'cbaRateCurrencyIso' => $currency,
                            'cbaRateUpdateDate' => $queryDate
                        )
                    );
                
                if(empty($rate)){ $rate = new CbaRate(); }
                
                $rate->setCbaRateCurrencyIso($currency);
                $rate->setCbaRateRate($dataRate);
                $rate->setCbaRateAmmount($amount);
                $rate->setCbaRateGetDate($dateNow);
                $rate->setCbaRateUpdateDate($queryDate);
                
                $em = $doctrine->getManager();
                $em->persist($rate);
                $em->flush();
                
            }
            
            
            if(!empty($historicalRates['date_next_available'])){
                if(!empty($dateTo) && $currentDay == $dateTo){
                    $this->nextAvailableDay = null;
                } else {
                    $this->nextAvailableDay = $nextDay;
                }
            } else {
                $this->nextAvailableDay = null;
            }
            
        }
        
        
    }
    
}
