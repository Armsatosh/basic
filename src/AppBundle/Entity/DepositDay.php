<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * DepositDay
 *
 * @ORM\Table(name="deposit_days")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepositDayRepository")
 */
class DepositDay
{
    
    /** 
     * @ORM\OneToMany(targetEntity="DepositsDepositDays", mappedBy="depositDay", cascade={"all"}) 
     */
    private $depositDepositDays;
    
    /**
     * @var string
     *
     * @ORM\Column(name="deposit_day_title", type="string", length=255, nullable=true)
     */
    private $depositDayTitle;
    
    /**
     * @var int
     *
     * @ORM\Column(name="deposit_day_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $depositDayId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="deposit_day_min", type="integer", nullable=true)
     */
    private $depositDayMin;

    /**
     * @var int
     *
     * @ORM\Column(name="deposit_day_max", type="integer", nullable=true)
     */
    private $depositDayMax;
    
    /**
     * @var int
     *
     * @ORM\Column(name="deposit_day_month", type="integer", nullable=true)
     */
    private $depositDayMonth;
    
    /**
     * Get depositDayId
     *
     * @return integer 
     */
    public function getDepositDayId()
    {
        return $this->depositDayId;
    }

    /**
     * Set depositDayMin
     *
     * @param integer $depositDayMin
     * @return DepositDay
     */
    public function setDepositDayMin($depositDayMin)
    {
        $this->depositDayMin = $depositDayMin;

        return $this;
    }

    /**
     * Get depositDayMin
     *
     * @return integer 
     */
    public function getDepositDayMin()
    {
        return $this->depositDayMin;
    }

    /**
     * Set depositDayMax
     *
     * @param integer $depositDayMax
     * @return DepositDayMax
     */
    public function setDepositDayMax($depositDayMax)
    {
        $this->depositDayMax = $depositDayMax;

        return $this;
    }

    /**
     * Get depositDayMax
     *
     * @return integer 
     */
    public function getDepositDayMax()
    {
        return $this->depositDayMax;
    }

    /**
     * Set deposit
     *
     * @param \AppBundle\Entity\Deposit $deposit
     * @return DepositDay
     */
    public function setDeposit(\AppBundle\Entity\Deposit $deposit = null)
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
     * Get depositId
     *
     * @return integer 
     */
    public function getDepositId()
    {
        return $this->depositId;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->deposits = new ArrayCollection();
    }

    /**
     * Add deposits
     *
     * @param \AppBundle\Entity\Deposit $deposits
     * @return DepositDay
     */
    public function addDeposit(\AppBundle\Entity\Deposit $deposits)
    {
        $this->deposits[] = $deposits;

        return $this;
    }

    /**
     * Remove deposits
     *
     * @param \AppBundle\Entity\Deposit $deposits
     */
    public function removeDeposit(\AppBundle\Entity\Deposit $deposits)
    {
        $this->deposits->removeElement($deposits);
    }

    /**
     * Get deposits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDeposits()
    {
        return $this->deposits;
    }

    /**
     * Set depositDayTitle
     *
     * @param string $depositDayTitle
     * @return DepositDay
     */
    public function setDepositDayTitle($depositDayTitle)
    {
        $this->depositDayTitle = $depositDayTitle;

        return $this;
    }

    /**
     * Get depositDayTitle
     *
     * @return string 
     */
    public function getDepositDayTitle()
    {
        return $this->depositDayTitle;
    }

    /**
     * Set depositDayMonth
     *
     * @param integer $depositDayMonth
     * @return DepositDay
     */
    public function setDepositDayMonth($depositDayMonth)
    {
        $this->depositDayMonth = $depositDayMonth;

        return $this;
    }

    /**
     * Get depositDayMonth
     *
     * @return integer 
     */
    public function getDepositDayMonth()
    {
        return $this->depositDayMonth;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getDepositDayTitle();
    }
    

    /**
     * Add depositDepositDays
     *
     * @param \AppBundle\Entity\DepositsDepositDays $depositDepositDays
     * @return DepositDay
     */
    public function addDepositDepositDay(\AppBundle\Entity\DepositsDepositDays $depositDepositDays)
    {
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
}
