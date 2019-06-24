<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * RateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RateRepository extends EntityRepository
{
    
    public function getLatestRecordDate(){
        
        $latestDate = $this->createQueryBuilder('r')
            ->where('r.bankId <> 13')
            ->orderBy('r.rateUpdateDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        
        return $latestDate;
        
    }
    
    public function getHSBCLatestRecordDate(){
        
        $latestDate = $this->createQueryBuilder('r')
            ->where('r.bankId = 13')
            ->orderBy('r.rateUpdateDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        
        return $latestDate;
        
    }
    
    
    
}
