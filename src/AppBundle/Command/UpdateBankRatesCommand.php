<?php

namespace AppBundle\Command;

use AppBundle\Entity\RateCurrent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use AppBundle\Entity\Data;
use AppBundle\Entity\Rate;

class UpdateBankRatesCommand extends ContainerAwareCommand
{
    
    protected function configure()
    {
        
        $this
            // the name of the command (the part after "app/console")
            ->setName('rates:get-bank-rates')

            // the short description shown while running "php app/console list"
            ->setDescription('Get rates from banks')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command activates code for parsing rates from Armenian banks')
        ;
        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // $file = "/var/www/www-root/data/www/www.bankinfo.am/app/logs/rates_banks.log";
//        $file = "C:/xampp/htdocs/dev_bankInfo_local/app/logs/rates_banks.log";

        $doctrine = $this->getContainer()->get('doctrine');

        $data = new Data;
        $repositoryRates = $doctrine->getRepository('AppBundle:Rate');
        $repositoryRatesCurrent = $doctrine->getRepository('AppBundle:RateCurrent');
        $repositoryCurrencies = $doctrine->getRepository('AppBundle:Currency');
        $repositoryBanks = $doctrine->getRepository('AppBundle:Bank');

        $currencies = $repositoryCurrencies->findAll();
        $banks = $repositoryBanks->findAll();

        $currentRates = $repositoryRatesCurrent->findAll();

        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Running Parser',
            '==============',
            '',
        ]);

        $rates = $data->getBankRates($banks, $currencies);

        // outputs a message followed by a "\n"
        $output->writeln([
            'Saving Data to Database',
            '=======================',
            '',
        ]);

        $date = new \DateTime();

//        file_put_contents($file, "<<< ".date('d-m-Y H:i:s')."\n", FILE_APPEND);
//        file_put_contents($file, "--------------------------------------\n", FILE_APPEND);
//        file_put_contents($file, "Save Status:\n", FILE_APPEND);

        if(!empty($rates)){

            foreach($rates as $bankId => $bank){

                $currentBank = $repositoryBanks->findOneByBankId($bankId);

                foreach($bank as $currencyId => $currency){

                    $currentRateBankQuery = $repositoryRatesCurrent->createQueryBuilder('rc')
                        ->where('rc.currencyId = :currency')
                        ->andWhere('rc.bankId = :bank')
                        ->setParameter('currency', $currencyId)
                        ->setParameter('bank', $bankId)
                        ->getQuery()
                    ;
                    $currentRateBank = $currentRateBankQuery->getOneOrNullResult();

                    $currentCurrency = $repositoryCurrencies->findOneByCurrencyId($currencyId);

                    if(!empty($currency['buy']) && !empty($currency['buyNonCash'])) {
                        $rate = new Rate();
                        $rate->setBank($currentBank);
                        $rate->setCurrency($currentCurrency);
                        $rate->setRateBuy($currency['buy']);
                        $rate->setRateSell($currency['sell']);
                        $rate->setRateNonCashBuy($currency['buyNonCash']);
                        $rate->setRateNonCashSell($currency['sellNonCash']);
                        $rate->setRateUpdateDate($date);
                        $em = $doctrine->getManager();
                        $em->persist($rate);
                        $em->flush();
                    }

//                    if($rate->getRateId() != null){
//                        file_put_contents($file, "- Success:: Bank: ".$bankId.", Currency: ".$currencyId."\n", FILE_APPEND);
//                    } else {
//                        file_put_contents($file, "- Error:: Bank: ".$bankId.", Currency: ".$currencyId."\n", FILE_APPEND);
//                    }

                    // Current rates
                    if($currentRateBank){
                        if(!empty($currency['buy']) && !empty($currency['buyNonCash'])) {
                            $currentRateBank->setBank($currentBank);
                            $currentRateBank->setCurrency($currentCurrency);
                            $currentRateBank->setRateBuy($currency['buy']);
                            $currentRateBank->setRateSell($currency['sell']);
                            $currentRateBank->setRateNonCashBuy($currency['buyNonCash']);
                            $currentRateBank->setRateNonCashSell($currency['sellNonCash']);
                            $currentRateBank->setRateUpdateDate($date);
                            $em = $doctrine->getManager();
                            $em->persist($currentRateBank);
                            $em->flush();
                        }
                    } else {
                        if(!empty($currency['buy']) && !empty($currency['buyNonCash'])) {
                            $currentRateBank = new RateCurrent();
                            $currentRateBank->setBank($currentBank);
                            $currentRateBank->setCurrency($currentCurrency);
                            $currentRateBank->setRateBuy($currency['buy']);
                            $currentRateBank->setRateSell($currency['sell']);
                            $currentRateBank->setRateNonCashBuy($currency['buyNonCash']);
                            $currentRateBank->setRateNonCashSell($currency['sellNonCash']);
                            $currentRateBank->setRateUpdateDate($date);
                            $em = $doctrine->getManager();
                            $em->persist($currentRateBank);
                            $em->flush();
                        }

                    }

                }
                
            }
            
        }
        
//        file_put_contents($file, "--------------------------------------\n", FILE_APPEND);
//        file_put_contents($file, json_encode($rates)."\n", FILE_APPEND);
//        file_put_contents($file, "======================================\n\n", FILE_APPEND);
        
        // outputs a message without adding a "\n" at the end of the line
        $output->writeln([
            'Success: New data added',
            '=======================',
            '',
        ]);
        
    }
    
}
