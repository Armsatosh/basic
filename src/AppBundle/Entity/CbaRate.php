<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;

/**
 * CbaRate
 *
 * @ORM\Table(name="cba_rates")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CbaRateRepository")
 */
class CbaRate
{
    /**
     * @var int
     *
     * @ORM\Column(name="cba_rate_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cbaRateId;

    /**
     * @var float
     *
     * @ORM\Column(name="cba_rate_currency_iso", type="string", length=4, nullable=true)
     */
    private $cbaRateCurrencyIso;
    
    /**
     * @var float
     *
     * @ORM\Column(name="cba_rate_ammount", type="float", nullable=true)
     */
    private $cbaRateAmmount;
    
    /**
     * @var float
     *
     * @ORM\Column(name="cba_rate_rate", type="float", nullable=true)
     */
    private $cbaRateRate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cba_rate_get_date", type="datetime")
     */
    private $cbaRateGetDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cba_rate_update_date", type="datetime")
     */
    private $cbaRateUpdateDate;

    /**
     * Get cbaRateId
     *
     * @return integer 
     */
    public function getCbaRateId()
    {
        return $this->cbaRateId;
    }

    /**
     * Set cbaRateRate
     *
     * @param float $cbaRateRate
     * @return CbaRate
     */
    public function setCbaRateRate($cbaRateRate)
    {
        $this->cbaRateRate = $cbaRateRate;

        return $this;
    }

    /**
     * Get cbaRateRate
     *
     * @return float 
     */
    public function getCbaRateRate()
    {
        return $this->cbaRateRate;
    }

    /**
     * Set cbaRateUpdateDate
     *
     * @param \DateTime $cbaRateUpdateDate
     * @return CbaRate
     */
    public function setCbaRateUpdateDate($cbaRateUpdateDate)
    {
        $this->cbaRateUpdateDate = $cbaRateUpdateDate;

        return $this;
    }

    /**
     * Get cbaRateUpdateDate
     *
     * @return \DateTime 
     */
    public function getCbaRateUpdateDate()
    {
        return $this->cbaRateUpdateDate;
    }

    /**
     * Set cbaRateCurrencyIso
     *
     * @param string $cbaRateCurrencyIso
     * @return CbaRate
     */
    public function setCbaRateCurrencyIso($cbaRateCurrencyIso)
    {
        $this->cbaRateCurrencyIso = $cbaRateCurrencyIso;

        return $this;
    }

    /**
     * Get cbaRateCurrencyIso
     *
     * @return string 
     */
    public function getCbaRateCurrencyIso()
    {
        return $this->cbaRateCurrencyIso;
    }

    /**
     * Set cbaRateAmmount
     *
     * @param float $cbaRateAmmount
     * @return CbaRate
     */
    public function setCbaRateAmmount($cbaRateAmmount)
    {
        $this->cbaRateAmmount = $cbaRateAmmount;

        return $this;
    }

    /**
     * Get cbaRateAmmount
     *
     * @return float 
     */
    public function getCbaRateAmmount()
    {
        return $this->cbaRateAmmount;
    }

    /**
     * Set cbaRateGetDate
     *
     * @param \DateTime $cbaRateGetDate
     * @return CbaRate
     */
    public function setCbaRateGetDate($cbaRateGetDate)
    {
        $this->cbaRateGetDate = $cbaRateGetDate;

        return $this;
    }

    /**
     * Get cbaRateGetDate
     *
     * @return \DateTime 
     */
    public function getCbaRateGetDate()
    {
        return $this->cbaRateGetDate;
    }
    
}
