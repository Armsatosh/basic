<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompaniesGroceries
 *
 * @ORM\Table(name="deposits_deposit_days")
 * @ORM\Entity
 */
class DepositsDepositDays 
{
    
    /**
     * @var int
     *
     * @ORM\Column(name="deposit_deposit_day_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $depositDepositDayId;
    
    /**
     * @var \AppBundle\Entity\Deposit
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Deposit", inversedBy="depositDepositDays")
     * @ORM\JoinColumn(name="deposit_id", referencedColumnName="deposit_id", nullable=false)
     */
    private $deposit;
    
    /**
     * @var \AppBundle\Entity\DepositDay
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DepositDay", inversedBy="depositDepositDays")
     * @ORM\JoinColumn(name="deposit_day_id", referencedColumnName="deposit_day_id", nullable=false)
     */
    private $depositDay;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="deposit_id", type="integer") 
     */
    private $depositId;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="deposit_day_id", type="integer") 
     */
    private $depositDayId;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="deposit_deposit_day_percent", type="float") 
     */
    private $depositDepositDayPercent;

    /**
     * Get depositDepositDayId
     *
     * @return integer 
     */
    public function getDepositDepositDayId()
    {
        return $this->depositDepositDayId;
    }

    /**
     * Set depositDepositDayPercent
     *
     * @param integer $depositDepositDayPercent
     * @return DepositsDepositDays
     */
    public function setDepositDepositDayPercent($depositDepositDayPercent)
    {
        $this->depositDepositDayPercent = $depositDepositDayPercent;

        return $this;
    }

    /**
     * Get depositDepositDayPercent
     *
     * @return integer 
     */
    public function getDepositDepositDayPercent()
    {
        return $this->depositDepositDayPercent;
    }

    /**
     * Set deposit
     *
     * @param \AppBundle\Entity\Deposit $deposit
     * @return DepositsDepositDays
     */
    public function setDeposit(\AppBundle\Entity\Deposit $deposit)
    {
        $this->deposit = $deposit;

        return $this;
    }

    /**
     * Get deposit
     *
     * @return \AppBundle\Entity\Deposit 
     */
    public function getDeposit()
    {
        return $this->deposit;
    }

    /**
     * Set depositDay
     *
     * @param \AppBundle\Entity\DepositDay $depositDay
     * @return DepositsDepositDays
     */
    public function setDepositDay(\AppBundle\Entity\DepositDay $depositDay)
    {
        $this->depositDay = $depositDay;

        return $this;
    }

    /**
     * Get depositDay
     *
     * @return \AppBundle\Entity\DepositDay 
     */
    public function getDepositDay()
    {
        return $this->depositDay;
    }

    /**
     * Set depositId
     *
     * @param integer $depositId
     * @return DepositsDepositDays
     */
    public function setDepositId($depositId)
    {
        $this->depositId = $depositId;

        return $this;
    }

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
     * Set depositDayId
     *
     * @param integer $depositDayId
     * @return DepositsDepositDays
     */
    public function setDepositDayId($depositDayId)
    {
        $this->depositDayId = $depositDayId;

        return $this;
    }

    /**
     * Get depositDayId
     *
     * @return integer 
     */
    public function getDepositDayId()
    {
        return $this->depositDayId;
    }
}
