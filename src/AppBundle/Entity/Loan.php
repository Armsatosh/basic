<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Loan
 *
 * @ORM\Table(name="loans")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoanRepository")
 */
class Loan
{
    /**
     * @ORM\ManyToOne(targetEntity="LoanGroup", inversedBy="loans")
     * @ORM\JoinColumn(name="loan_group_id", referencedColumnName="loan_group_id")
     * 
     */
    private $loanGroup;
    
    /**
     * @ORM\ManyToOne(targetEntity="Bank", inversedBy="loans")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     * 
     */
    private $bank;
    
    /**
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="loans")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="currency_id")
     * 
     */
    private $currency;

    /**
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="loans")
     * @ORM\JoinColumn(name="loan_currency_min", referencedColumnName="currency_id")
     *
     */
    private $currencyMin;

    /**
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="loans")
     * @ORM\JoinColumn(name="loan_currency_max", referencedColumnName="currency_id")
     *
     */
    private $currencyMax;
    
    /**
     * @var int
     *
     * @ORM\Column(name="loan_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $loanId;

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
     * @ORM\Column(name="loan_group_id", type="integer")
     */
    private $loanGroupId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="loan_order", type="integer")
     */
    private $loanOrder;

    /**
     * @var int
     *
     * @ORM\Column(name="loan_customer_type", type="integer")
     */
    private $loanCustomerType;

    /**
     * @var string
     *
     * @ORM\Column(name="loan_title", type="string", length=255, nullable=true)
     */
    private $loanTitle;

    /**
     * @var float
     *
     * @ORM\Column(name="loan_min", type="float", nullable=true)
     */
    private $loanMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="loan_currency_min", type="integer", nullable=true)
     */
    private $loanCurrencyMin;

    /**
     * @var float
     *
     * @ORM\Column(name="loan_max", type="float", nullable=true)
     */
    private $loanMax;

    /**
     * @var integer
     *
     * @ORM\Column(name="loan_currency_max", type="integer", nullable=true)
     */
    private $loanCurrencyMax;
    
    /**
     * @var int
     *
     * @ORM\Column(name="loan_equivalent_amd", type="integer")
     */
    private $loanEquivalentAmd;
    
    /**
     * @var float
     *
     * @ORM\Column(name="loan_terms_min", type="float", nullable=true)
     */
    private $loanTermsMin;

    /**
     * @var float
     *
     * @ORM\Column(name="loan_terms_max", type="float", nullable=true)
     */
    private $loanTermsMax;

    /**
     * @var float
     *
     * @ORM\Column(name="loan_deposit_percent_min", type="float", nullable=true)
     */
    private $loanDepositPercentMin;

    /**
     * @var float
     *
     * @ORM\Column(name="loan_deposit_percent_max", type="float", nullable=true)
     */
    private $loanDepositPercentMax;

    /**
     * @var float
     *
     * @ORM\Column(name="loan_percent_min", type="float", nullable=true)
     */
    private $loanPercentMin;

    /**
     * @var float
     *
     * @ORM\Column(name="loan_percent_max", type="float", nullable=true)
     */
    private $loanPercentMax;

    /**
     * @var float
     *
     * @ORM\Column(name="loan_percent_subsidized", type="float", nullable=true)
     */
    private $loanPercentSubsidized;

    /**
     * @var string
     *
     * @ORM\Column(name="loan_link", type="string", length=2000, nullable=true)
     */
    private $loanLink;

    /**
     * @var string
     *
     * @ORM\Column(name="loan_description", type="text", nullable=true)
     */
    private $loanDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="loan_update_date", type="datetime", nullable=true)
     */
    private $loanUpdateDate;

    /**
     * Get loanId
     *
     * @return integer 
     */
    public function getLoanId()
    {
        return $this->loanId;
    }

    /**
     * Set loanOrder
     *
     * @param integer $loanOrder
     * @return Loan
     */
    public function setLoanOrder($loanOrder)
    {
        $this->loanOrder = $loanOrder;

        return $this;
    }

    /**
     * Get loanOrder
     *
     * @return integer 
     */
    public function getLoanOrder()
    {
        return $this->loanOrder;
    }

    /**
     * Set loanCustomerType
     *
     * @param integer $loanCustomerType
     * @return Loan
     */
    public function setLoanCustomerType($loanCustomerType)
    {
        $this->loanCustomerType = $loanCustomerType;

        return $this;
    }

    /**
     * Get loanCustomerType
     *
     * @return integer 
     */
    public function getLoanCustomerType()
    {
        return $this->loanCustomerType;
    }

    /**
     * Set loanTitle
     *
     * @param string $loanTitle
     * @return Loan
     */
    public function setLoanTitle($loanTitle)
    {
        $this->loanTitle = $loanTitle;

        return $this;
    }

    /**
     * Get loanTitle
     *
     * @return string 
     */
    public function getLoanTitle()
    {
        return $this->loanTitle;
    }

    /**
     * Set loanMin
     *
     * @param float $loanMin
     * @return Loan
     */
    public function setLoanMin($loanMin)
    {
        $this->loanMin = $loanMin;

        return $this;
    }

    /**
     * Get loanMin
     *
     * @return float 
     */
    public function getLoanMin()
    {
        return $this->loanMin;
    }

    /**
     * Set loanMax
     *
     * @param float $loanMax
     * @return Loan
     */
    public function setLoanMax($loanMax)
    {
        $this->loanMax = $loanMax;

        return $this;
    }

    /**
     * Get loanMax
     *
     * @return float 
     */
    public function getLoanMax()
    {
        return $this->loanMax;
    }

    /**
     * Set loanTermsMin
     *
     * @param float $loanTermsMin
     * @return Loan
     */
    public function setLoanTermsMin($loanTermsMin)
    {
        $this->loanTermsMin = $loanTermsMin;

        return $this;
    }

    /**
     * Get loanTermsMin
     *
     * @return float 
     */
    public function getLoanTermsMin()
    {
        return $this->loanTermsMin;
    }

    /**
     * Set loanTermsMax
     *
     * @param float $loanTermsMax
     * @return Loan
     */
    public function setLoanTermsMax($loanTermsMax)
    {
        $this->loanTermsMax = $loanTermsMax;

        return $this;
    }

    /**
     * Get loanTermsMax
     *
     * @return float 
     */
    public function getLoanTermsMax()
    {
        return $this->loanTermsMax;
    }

    /**
     * Set loanDepositPercentMin
     *
     * @param float $loanDepositPercentMin
     * @return Loan
     */
    public function setLoanDepositPercentMin($loanDepositPercentMin)
    {
        $this->loanDepositPercentMin = $loanDepositPercentMin;

        return $this;
    }

    /**
     * Get loanDepositPercentMin
     *
     * @return float 
     */
    public function getLoanDepositPercentMin()
    {
        return $this->loanDepositPercentMin;
    }

    /**
     * Set loanDepositPercentMax
     *
     * @param float $loanDepositPercentMax
     * @return Loan
     */
    public function setLoanDepositPercentMax($loanDepositPercentMax)
    {
        $this->loanDepositPercentMax = $loanDepositPercentMax;

        return $this;
    }

    /**
     * Get loanDepositPercentMax
     *
     * @return float 
     */
    public function getLoanDepositPercentMax()
    {
        return $this->loanDepositPercentMax;
    }

    /**
     * Set loanPercentMin
     *
     * @param float $loanPercentMin
     * @return Loan
     */
    public function setLoanPercentMin($loanPercentMin)
    {
        $this->loanPercentMin = $loanPercentMin;

        return $this;
    }

    /**
     * Get loanPercentMin
     *
     * @return float 
     */
    public function getLoanPercentMin()
    {
        return $this->loanPercentMin;
    }

    /**
     * Set loanPercentMax
     *
     * @param float $loanPercentMax
     * @return Loan
     */
    public function setLoanPercentMax($loanPercentMax)
    {
        $this->loanPercentMax = $loanPercentMax;

        return $this;
    }

    /**
     * Get loanPercentMax
     *
     * @return float 
     */
    public function getLoanPercentMax()
    {
        return $this->loanPercentMax;
    }

    /**
     * Set loanPercentSubsidized
     *
     * @param float $loanPercentSubsidized
     * @return Loan
     */
    public function setLoanPercentSubsidized($loanPercentSubsidized)
    {
        $this->loanPercentSubsidized = $loanPercentSubsidized;

        return $this;
    }

    /**
     * Get loanPercentSubsidized
     *
     * @return float 
     */
    public function getLoanPercentSubsidized()
    {
        return $this->loanPercentSubsidized;
    }

    /**
     * Set loanLink
     *
     * @param string $loanLink
     * @return Loan
     */
    public function setLoanLink($loanLink)
    {
        $this->loanLink = $loanLink;

        return $this;
    }

    /**
     * Get loanLink
     *
     * @return string 
     */
    public function getLoanLink()
    {
        return $this->loanLink;
    }

    /**
     * Set loanDescription
     *
     * @param string $loanDescription
     * @return Loan
     */
    public function setLoanDescription($loanDescription)
    {
        $this->loanDescription = $loanDescription;

        return $this;
    }

    /**
     * Get loanDescription
     *
     * @return string 
     */
    public function getLoanDescription()
    {
        return $this->loanDescription;
    }

    /**
     * Set loanUpdateDate
     *
     * @param \DateTime $loanUpdateDate
     * @return Loan
     */
    public function setLoanUpdateDate($loanUpdateDate)
    {
        $this->loanUpdateDate = $loanUpdateDate;

        return $this;
    }

    /**
     * Get loanUpdateDate
     *
     * @return \DateTime 
     */
    public function getLoanUpdateDate()
    {
        return $this->loanUpdateDate;
    }

    /**
     * Set loanGroup
     *
     * @param \AppBundle\Entity\LoanGroup $loanGroup
     * @return Loan
     */
    public function setLoanGroup(\AppBundle\Entity\LoanGroup $loanGroup = null)
    {
        $this->loanGroup = $loanGroup;

        return $this;
    }

    /**
     * Get loanGroup
     *
     * @return \AppBundle\Entity\LoanGroup 
     */
    public function getLoanGroup()
    {
        return $this->loanGroup;
    }

    /**
     * Set bank
     *
     * @param \AppBundle\Entity\Bank $bank
     * @return Loan
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
     * @return Loan
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

    public function setCurrencyMin(\AppBundle\Entity\Currency $currencyMin = null)
    {
        $this->currencyMin = $currencyMin;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \AppBundle\Entity\Currency
     */
    public function getCurrencyMin()
    {
        return $this->currencyMin;
    }

    public function setCurrencyMax(\AppBundle\Entity\Currency $currencyMax = null)
    {
        $this->currencyMax = $currencyMax;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \AppBundle\Entity\Currency
     */
    public function getCurrencyMax()
    {
        return $this->currencyMax;
    }

    /**
     * Set bankId
     *
     * @param integer $bankId
     * @return Loan
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
     * @return Loan
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
     * Set loanGroupId
     *
     * @param integer $loanGroupId
     * @return Loan
     */
    public function setLoanGroupId($loanGroupId)
    {
        $this->loanGroupId = $loanGroupId;

        return $this;
    }

    /**
     * Get loanGroupId
     *
     * @return integer 
     */
    public function getLoanGroupId()
    {
        return $this->loanGroupId;
    }

    /**
     * Set loanEquivalentAmd
     *
     * @param integer $loanEquivalentAmd
     * @return Loan
     */
    public function setLoanEquivalentAmd($loanEquivalentAmd)
    {
        $this->loanEquivalentAmd = $loanEquivalentAmd;

        return $this;
    }

    /**
     * Get loanEquivalentAmd
     *
     * @return integer 
     */
    public function getLoanEquivalentAmd()
    {
        return $this->loanEquivalentAmd;
    }

    /**
     * @return string
     */
    public function getLoanCurrencyMin()
    {
        return $this->loanCurrencyMin;
    }

    /**
     * @param string $loanCurrencyMin
     */
    public function setLoanCurrencyMin($loanCurrencyMin)
    {
        $this->loanCurrencyMin = $loanCurrencyMin;
    }

    /**
     * @return string
     */
    public function getLoanCurrencyMax()
    {
        return $this->loanCurrencyMax;
    }

    /**
     * @param string $loanCurrencyMax
     */
    public function setLoanCurrencyMax($loanCurrencyMax)
    {
        $this->loanCurrencyMax = $loanCurrencyMax;
    }
}
