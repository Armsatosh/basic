<?php

namespace AppBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class AppExtension extends \Twig_Extension {

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('to_int', array($this, 'to_intFilter')),
            new \Twig_SimpleFilter('to_float', array($this, 'to_floatFilter')),
            new \Twig_SimpleFilter('decimal_zero', array($this, 'decimalZero')),
            new \Twig_SimpleFilter('json_decode', array($this, 'json_decodeFilter')),
            new \Twig_SimpleFilter('last_not_null', array($this, 'getLastNotNull')),
        );
    }

    public function to_intFilter($string) {
        $int = intval($string);
        return $int;
    }
    public function to_floatFilter($string) {
        $float = floatval($string);
        return $float;
    }
    public function json_decodeFilter($string) {
        $json_to_array = json_decode($string, true);
        return $json_to_array;
    }

    public function decimalZero($float, $decimals){

        $return_val = $float;

        if(!is_float($float)){
            $float = $this->to_floatFilter($float);
        }

        $fractal = $float - floor($float);

        if($fractal == 0){
            $return_val = floor($float);
        } else {
            $return_val = number_format($float, $decimals);
        }

        return $return_val;

    }

    public function getLastNotNull($def, $dateFrom, $dateTo, $currencySymbol){

        $returnData = " ";

        $cbaRepository = $this->em->getRepository('AppBundle:CbaRate');
        $latestNotNullRate = $cbaRepository->getLatestNotNullRate($dateFrom, $dateTo, $currencySymbol);

        if(!empty($latestNotNullRate)){
            $returnData = number_format($latestNotNullRate[0]['cba_rate_rate'], 2);
        }

        return $returnData;

    }
    
    public function getName() {
        return 'app_extension';
    }
    
}
