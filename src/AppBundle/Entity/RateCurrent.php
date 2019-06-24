<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rate
 *
 * @ORM\Table(name="rates_current")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RateCurrentRepository")
 */
class RateCurrent
{
    /**
     * @var int
     *
     * @ORM\Column(name="rate_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $rateId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Bank", inversedBy="rateCurrent")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     * 
     */
    private $bank;
    
    /**
     * @var int
     *
     * @ORM\Column(name="bank_id", type="integer", nullable=true)
     */
    private $bankId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="rates")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="currency_id")
     * 
     */
    private $currency;
    
    /**
     * @var int
     *
     * @ORM\Column(name="currency_id", type="integer", nullable=true)
     */
    private $currencyId;
    
    /**
     * @var float
     *
     * @ORM\Column(name="rate_buy", type="float", nullable=true)
     */
    private $rateBuy;
    
    /**
     * @var float
     *
     * @ORM\Column(name="rate_sell", type="float", nullable=true)
     */
    private $rateSell;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rate_update_date", type="datetime", nullable=true)
     */
    private $rateUpdateDate;

    /**
     * @ORM\Column(name="rate_non_cash_buy", type="float", nullable=true)
     */
    private $rateNonCashBuy;

    /**
     * @ORM\Column(name="rate_non_cash_sell", type="float", nullable=true)
     */
    private $rateNonCashSell;

    /**
     * Get rateId
     *
     * @return integer 
     */
    public function getRateId()
    {
        return $this->rateId;
    }

    /**
     * Set rateRate
     *
     * @param float $rateRate
     * @return Rate
     */
    public function setRateRate($rateRate)
    {
        $this->rateRate = $rateRate;

        return $this;
    }

    /**
     * Get rateRate
     *
     * @return float 
     */
    public function getRateRate()
    {
        return $this->rateRate;
    }

    /**
     * Set rateUpdateDate
     *
     * @param \DateTime $rateUpdateDate
     * @return Rate
     */
    public function setRateUpdateDate($rateUpdateDate)
    {
        $this->rateUpdateDate = $rateUpdateDate;

        return $this;
    }

    /**
     * Get rateUpdateDate
     *
     * @return \DateTime 
     */
    public function getRateUpdateDate()
    {
        return $this->rateUpdateDate;
    }

    /**
     * Set rateBuy
     *
     * @param float $rateBuy
     * @return Rate
     */
    public function setRateBuy($rateBuy)
    {
        $this->rateBuy = $rateBuy;

        return $this;
    }

    /**
     * Get rateBuy
     *
     * @return float 
     */
    public function getRateBuy()
    {
        return $this->rateBuy;
    }

    /**
     * Set rateSell
     *
     * @param float $rateSell
     * @return Rate
     */
    public function setRateSell($rateSell)
    {
        $this->rateSell = $rateSell;

        return $this;
    }

    /**
     * Get rateSell
     *
     * @return float 
     */
    public function getRateSell()
    {
        return $this->rateSell;
    }

    /**
     * Set bank
     *
     * @param \AppBundle\Entity\Bank $bank
     * @return Rate
     */
    public function setBank(\AppBundle\Entity\Bank $bank = null)
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Get bank
     *
     * @return \AppBundle\Entity\Bank 
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set currency
     *
     * @param \AppBundle\Entity\Currency $currency
     * @return Rate
     */
    public function setCurrency(\AppBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \AppBundle\Entity\Currency 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set bankId
     *
     * @param integer $bankId
     * @return Rate
     */
    public function setBankId($bankId)
    {
        $this->bankId = $bankId;

        return $this;
    }

    /**
     * Get bankId
     *
     * @return integer 
     */
    public function getBankId()
    {
        return $this->bankId;
    }

    /**
     * Set currencyId
     *
     * @param integer $currencyId
     * @return Rate
     */
    public function setCurrencyId($currencyId)
    {
        $this->currencyId = $currencyId;

        return $this;
    }

    /**
     * Get currencyId
     *
     * @return integer 
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    /**
     * @return mixed
     */
    public function getRateNonCashBuy()
    {
        return $this->rateNonCashBuy;
    }

    /**
     * @param mixed $rateNonCashBuy
     */
    public function setRateNonCashBuy($rateNonCashBuy)
    {
        $this->rateNonCashBuy = $rateNonCashBuy;
    }

    /**
     * @return mixed
     */
    public function getRateNonCashSell()
    {
        return $this->rateNonCashSell;
    }

    /**
     * @param mixed $rateNonCashSell
     */
    public function setRateNonCashSell($rateNonCashSell)
    {
        $this->rateNonCashSell = $rateNonCashSell;
    }

}
