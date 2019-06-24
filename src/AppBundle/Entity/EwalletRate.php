<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EwalletRate
 *
 * @ORM\Table(name="ewallet_rates")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EwalletRateRepository")
 */
class EwalletRate
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Ewallet", inversedBy="ewalletRates")
     * @ORM\JoinColumn(name="ewallet_id", referencedColumnName="ewallet_id")
     * 
     */
    private $ewallet;
    
    /**
     * @ORM\ManyToOne(targetEntity="Bank", inversedBy="ewalletRates")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     * 
     */
    private $bank;
    
    /**
     * @var int
     *
     * @ORM\Column(name="ewallet_rate_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ewalletRateId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="ewallet_id", type="integer")
     */
    private $ewalletId;

    /**
     * @var int
     *
     * @ORM\Column(name="bank_id", type="integer")
     */
    private $bankId;

    /**
     * @var float
     *
     * @ORM\Column(name="ewallet_rate_refill", type="float", nullable=true)
     */
    private $ewalletRateRefill;

    /**
     * @var float
     *
     * @ORM\Column(name="ewallet_rate_withdraw", type="float", nullable=true)
     */
    private $ewalletRateWithdraw;

    /**
     * @var string
     *
     * @ORM\Column(name="ewallet_rate_link", type="string", length=255, nullable=true)
     */
    private $ewalletRateLink;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="ewallet_rate_update_date", type="datetime", nullable=true)
     */
    private $ewalletRateUpdateDate;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ewalletRateId
     *
     * @param integer $ewalletRateId
     * @return EwalletRate
     */
    public function setEwalletRateId($ewalletRateId)
    {
        $this->ewalletRateId = $ewalletRateId;

        return $this;
    }

    /**
     * Get ewalletRateId
     *
     * @return integer 
     */
    public function getEwalletRateId()
    {
        return $this->ewalletRateId;
    }

    /**
     * Set ewalletId
     *
     * @param integer $ewalletId
     * @return EwalletRate
     */
    public function setEwalletId($ewalletId)
    {
        $this->ewalletId = $ewalletId;

        return $this;
    }

    /**
     * Get ewalletId
     *
     * @return integer 
     */
    public function getEwalletId()
    {
        return $this->ewalletId;
    }

    /**
     * Set bankId
     *
     * @param integer $bankId
     * @return EwalletRate
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
     * Set ewalletRateRefill
     *
     * @param float $ewalletRateRefill
     * @return EwalletRate
     */
    public function setEwalletRateRefill($ewalletRateRefill)
    {
        $this->ewalletRateRefill = $ewalletRateRefill;

        return $this;
    }

    /**
     * Get ewalletRateRefill
     *
     * @return float 
     */
    public function getEwalletRateRefill()
    {
        return $this->ewalletRateRefill;
    }

    /**
     * Set ewalletRateWithdraw
     *
     * @param float $ewalletRateWithdraw
     * @return EwalletRate
     */
    public function setEwalletRateWithdraw($ewalletRateWithdraw)
    {
        $this->ewalletRateWithdraw = $ewalletRateWithdraw;

        return $this;
    }

    /**
     * Get ewalletRateWithdraw
     *
     * @return float 
     */
    public function getEwalletRateWithdraw()
    {
        return $this->ewalletRateWithdraw;
    }

    /**
     * Set ewalletRateLink
     *
     * @param string $ewalletRateLink
     * @return EwalletRate
     */
    public function setEwalletRateLink($ewalletRateLink)
    {
        $this->ewalletRateLink = $ewalletRateLink;

        return $this;
    }

    /**
     * Get ewalletRateLink
     *
     * @return string 
     */
    public function getEwalletRateLink()
    {
        return $this->ewalletRateLink;
    }

    /**
     * Set ewallet
     *
     * @param \AppBundle\Entity\Ewallet $ewallet
     * @return EwalletRate
     */
    public function setEwallet(\AppBundle\Entity\Ewallet $ewallet = null)
    {
        $this->ewallet = $ewallet;

        return $this;
    }

    /**
     * Get ewallet
     *
     * @return \AppBundle\Entity\Ewallet 
     */
    public function getEwallet()
    {
        return $this->ewallet;
    }

    /**
     * Set bank
     *
     * @param \AppBundle\Entity\Bank $bank
     * @return EwalletRate
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
     * Set ewalletRateUpdateDate
     *
     * @param \DateTime $ewalletRateUpdateDate
     * @return EwalletRate
     */
    public function setEwalletRateUpdateDate($ewalletRateUpdateDate)
    {
        $this->ewalletRateUpdateDate = $ewalletRateUpdateDate;

        return $this;
    }

    /**
     * Get ewalletRateUpdateDate
     *
     * @return \DateTime 
     */
    public function getEwalletRateUpdateDate()
    {
        return $this->ewalletRateUpdateDate;
    }
}
