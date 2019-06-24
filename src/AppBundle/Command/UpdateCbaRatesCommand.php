<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use AppBundle\Entity\Data;
use AppBundle\Entity\CbaRate;

class UpdateCbaRatesCommand extends ContainerAwareCommand
{
    
    protected function configure()
    {
        
        $this
            // the name of the command (the part after "app/console")
            ->setName('rates:get-cba-rates')

            // the short description shown while running "php app/console list"
            ->setDescription('Get rates from central bank')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command activates code for parsing rates from central bank of Armenia')
        ;
        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $file = "/var/www/www-root/data/www/www.bankinfo.am/app/logs/rates_cba.log";
        
        $doctrine = $this->getContainer()->get('doctrine');
        
        $dateNow = new \DateTime();
        $queryDate = new \DateTime($dateNow->format('Y-m-d')." 00:00:00");
        
        $data = new Data;
        $repositoryCbaRates = $doctrine->getRepository('AppBundle:CbaRate');
        
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Running Parser ...',
            '==================',
            '',
        ]);
        
        $rates = $data->getCbaRatesCurrent();
        
        // outputs a message followed by a "\n"
        $output->writeln([
            'Saving Data to Database ...',
            '===========================',
            '',
        ]);
        
        if(!empty($rates)){
            
            foreach($rates['rates'] as $rate){
                
                $amount = $rate['amount'];
                $currency = (string) $rate['iso'];
                $dataRate = floatval($rate['rate']);
                
//                $rate = $repositoryCbaRates->findByCbaRateUpdateDate($queryDate);
                $rate = $repositoryCbaRates->findOneBy(
                        array(
                            'cbaRateCurrencyIso' => $currency,
                            'cbaRateUpdateDate' => $queryDate
                        )
                    );
                
                if(empty($rate)){ $rate = new CbaRate(); }
                
               /* file_put_contents($file, "<<< ".date('d-m-Y H:i:s')."\n", FILE_APPEND);
                file_put_contents($file, "--------------------------------------\n", FILE_APPEND);
                file_put_contents($file, "Currency: ".$currency.", Rate: ".$dataRate.", Amount: ".$amount.", Rate Date: ".$queryDate->format("Y-m-d")."\n", FILE_APPEND);
                file_put_contents($file, "======================================\n\n\n", FILE_APPEND);*/
                
                $rate->setCbaRateCurrencyIso($currency);
                $rate->setCbaRateRate($dataRate);
                $rate->setCbaRateAmmount($amount);
                $rate->setCbaRateGetDate($dateNow);
                $rate->setCbaRateUpdateDate($queryDate);
                
                $em = $doctrine->getManager();
                $em->persist($rate);
                $em->flush();
                
            }
            
        } else {
            
            $output->writeln('No Data');
            
          /*  file_put_contents($file, "<<< ".date('d-m-Y H:i:s')."\n", FILE_APPEND);
            file_put_contents($file, "--------------------------------------\n", FILE_APPEND);
            file_put_contents($file, "No Data!!!\n", FILE_APPEND);
            file_put_contents($file, "======================================\n\n", FILE_APPEND);*/
            
        }
        
        // outputs a message without adding a "\n" at the end of the line
        $output->writeln([
            'Success: New data added',
            '=======================',
            '',
        ]);
        
    }
    
}
