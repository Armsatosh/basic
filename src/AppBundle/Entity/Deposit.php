<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Deposit
 *
 * @ORM\Table(name="deposits")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepositRepository")
 */
class Deposit
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Bank", inversedBy="deposits")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     * 
     */
    private $bank;
    
    /**
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="deposits")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="currency_id")
     * 
     */
    private $currency;


    /**
     * @ORM\Column(type="integer")
     */
    private $depositOrder;

    /**
     * @ORM\OneToMany(targetEntity="DepositsDepositDays", mappedBy="deposit", cascade={"persist"}, orphanRemoval=true) 
     */
    private $depositDepositDays;
    
    public function __construct()
    {
        $this->depositDays = new ArrayCollection();
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="deposit_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $depositId;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="bank_id", type="integer") 
     */
    private $bankId;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="currency_id", type="integer") 
     */
    private $currencyId;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="deposit_customer_type", type="integer") 
     */
    private $depositCustomerType;

    /**
     * @var float
     *
     * @ORM\Column(name="deposit_min", type="float", nullable=true)
     */
    private $depositMin;
    
    /**
     * @var float
     *
     * @ORM\Column(name="deposit_max", type="float", nullable=true)
     */
    private $depositMax;

    /**
     * @var string
     *
     * @ORM\Column(name="deposit_description", type="text", nullable=true)
     */
    private $depositDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="deposit_title", type="string", length=255, nullable=true)
     */
    private $depositTitle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deposit_update_date", type="datetime", nullable=true)
     */
    private $depositUpdateDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="deposit_link", type="string", length=2000, nullable=true)
     */
    private $depositLink;

    

    /**
     * Get depositId
     *
     * @return integer 
     */
    public function getDepositId()
    {
        return $this->depositId;
    }

    /**
     * Set bankId
     *
     * @param integer $bankId
     * @return Deposit
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
     * @return Deposit
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
     * Set depositCustomerType
     *
     * @param integer $depositCustomerType
     * @return Deposit
     */
    public function setDepositCustomerType($depositCustomerType)
    {
        $this->depositCustomerType = $depositCustomerType;

        return $this;
    }

    /**
     * Get depositCustomerType
     *
     * @return integer 
     */
    public function getDepositCustomerType()
    {
        return $this->depositCustomerType;
    }

    /**
     * Set depositMin
     *
     * @param float $depositMin
     * @return Deposit
     */
    public function setDepositMin($depositMin)
    {
        $this->depositMin = $depositMin;

        return $this;
    }

    /**
     * Get depositMin
     *
     * @return float 
     */
    public function getDepositMin()
    {
        return $this->depositMin;
    }

    /**
     * Set depositDescription
     *
     * @param string $depositDescription
     * @return Deposit
     */
    public function setDepositDescription($depositDescription)
    {
        $this->depositDescription = $depositDescription;

        return $this;
    }

    /**
     * Get depositDescription
     *
     * @return string 
     */
    public function getDepositDescription()
    {
        return $this->depositDescription;
    }

    /**
     * Set depositTitle
     *
     * @param string $depositTitle
     * @return Deposit
     */
    public function setDepositTitle($depositTitle)
    {
        $this->depositTitle = $depositTitle;

        return $this;
    }

    /**
     * Get depositTitle
     *
     * @return string 
     */
    public function getDepositTitle()
    {
        return $this->depositTitle;
    }

    /**
     * Set depositUpdateDate
     *
     * @param \DateTime $depositUpdateDate
     * @return Deposit
     */
    public function setDepositUpdateDate($depositUpdateDate)
    {
        $this->depositUpdateDate = $depositUpdateDate;

        return $this;
    }

    /**
     * Get depositUpdateDate
     *
     * @return \DateTime 
     */
    public function getDepositUpdateDate()
    {
        return $this->depositUpdateDate;
    }

    /**
     * Set depositLink
     *
     * @param string $depositLink
     * @return Deposit
     */
    public function setDepositLink($depositLink)
    {
        $this->depositLink = $depositLink;

        return $this;
    }

    /**
     * Get depositLink
     *
     * @return string 
     */
    public function getDepositLink()
    {
        return $this->depositLink;
    }

    /**
     * Set bank
     *
     * @param \AppBundle\Entity\Bank $bank
     * @return Deposit
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
     * @return Deposit
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
     * Add depositDepositDays
     *
     * @param \AppBundle\Entity\DepositsDepositDays $depositDepositDays
     * @return Deposit
     */
    public function addDepositDepositDay(\AppBundle\Entity\DepositsDepositDays $depositDepositDays)
    {
        $depositDepositDays->setDeposit($this);
        $this->depositDepositDays[] = $depositDepositDays;

        return $this;
    }

    /**
     * Remove depositDepositDays
     *
     * @param \AppBundle\Entity\DepositsDepositDays $depositDepositDays
     */
    public function removeDepositDepositDay(\AppBundle\Entity\DepositsDepositDays $depositDepositDays)
    {
        $this->depositDepositDays->removeElement($depositDepositDays);
    }

    /**
     * Get depositDepositDays
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepositDepositDays()
    {
        return $this->depositDepositDays;
    }

    /**
     * Set depositMax
     *
     * @param float $depositMax
     * @return Deposit
     */
    public function setDepositMax($depositMax)
    {
        $this->depositMax = $depositMax;

        return $this;
    }

    /**
     * Get depositMax
     *
     * @return float 
     */
    public function getDepositMax()
    {
        return $this->depositMax;
    }

    /**
     * @return mixed
     */
    public function getDepositOrder()
    {
        return $this->depositOrder;
    }

    /**
     * @param mixed $depositOrder
     */
    public function setDepositOrder($depositOrder)
    {
        $this->depositOrder = $depositOrder;
    }
}
