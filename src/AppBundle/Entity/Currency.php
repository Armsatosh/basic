<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Currency
 *
 * @ORM\Table(name="currencies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CurrencyRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CurrencyTranslation")
 */
class Currency extends AbstractPersonalTranslatable implements TranslatableInterface
{
    
    /**
     * @ORM\OneToMany(targetEntity="Loan", mappedBy="currency")
     */
    private $loans;
    
    /**
     * @ORM\OneToMany(targetEntity="Deposit", mappedBy="currency")
     */
    private $deposits;
    
    /**
     * @ORM\OneToMany(targetEntity="TransferCurrency", mappedBy="currency")
     */
    private $transferCurrencies;
    
    /**
     * @ORM\OneToMany(targetEntity="Rate", mappedBy="currency")
     */
    private $rates;
    
    /**
     * @var int
     *
     * @ORM\Column(name="currency_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $currencyId;

    /**
     * @var string
     *
     * @ORM\Column(name="currency_symbol", type="string", length=255, nullable=true)
     */
    private $currencySymbol;

    /**
     * @var int
     *
     * @ORM\Column(name="currency_order", type="integer", nullable=true)
     */
    private $currencyOrder;
    
    /**
     * @var int
     *
     * @ORM\Column(name="currency_units", type="integer", nullable=true)
     */
    private $currencyUnits;

    /**
     * @var string
     *
     * @ORM\Column(name="currency_title", type="string", length=255)
     */
    private $currencyTitle;
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    protected $locale;
    
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\CurrencyTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;
    
    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->loans = new ArrayCollection();
        $this->deposits = new ArrayCollection();
        $this->transferCurrencies = new ArrayCollection();
        $this->rates = new ArrayCollection();
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
     * Set currencySymbol
     *
     * @param string $currencySymbol
     * @return Currency
     */
    public function setCurrencySymbol($currencySymbol)
    {
        $this->currencySymbol = $currencySymbol;

        return $this;
    }

    /**
     * Get currencySymbol
     *
     * @return string 
     */
    public function getCurrencySymbol()
    {
        return $this->currencySymbol;
    }

    /**
     * Set currencyUnits
     *
     * @param integer $currencyUnits
     * @return Currency
     */
    public function setCurrencyUnits($currencyUnits)
    {
        $this->currencyUnits = $currencyUnits;

        return $this;
    }

    /**
     * Get currencyUnits
     *
     * @return integer 
     */
    public function getCurrencyUnits()
    {
        return $this->currencyUnits;
    }

    /**
     * Set currencyTitle
     *
     * @param string $currencyTitle
     * @return Currency
     */
    public function setCurrencyTitle($currencyTitle)
    {
        $this->currencyTitle = $currencyTitle;

        return $this;
    }

    /**
     * Get currencyTitle
     *
     * @return string 
     */
    public function getCurrencyTitle()
    {
        return $this->currencyTitle;
    }

    /**
     * Add loans
     *
     * @param \AppBundle\Entity\Loan $loans
     * @return Currency
     */
    public function addLoan(\AppBundle\Entity\Loan $loans)
    {
        $this->loans[] = $loans;

        return $this;
    }

    /**
     * Remove loans
     *
     * @param \AppBundle\Entity\Loan $loans
     */
    public function removeLoan(\AppBundle\Entity\Loan $loans)
    {
        $this->loans->removeElement($loans);
    }

    /**
     * Get loans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLoans()
    {
        return $this->loans;
    }

    /**
     * Add deposits
     *
     * @param \AppBundle\Entity\Deposit $deposits
     * @return Currency
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
     * Add transferCurrencies
     *
     * @param \AppBundle\Entity\TransferCurrency $transferCurrencies
     * @return Currency
     */
    public function addTransferCurrency(\AppBundle\Entity\TransferCurrency $transferCurrencies)
    {
        $this->transferCurrencies[] = $transferCurrencies;

        return $this;
    }

    /**
     * Remove transferCurrencies
     *
     * @param \AppBundle\Entity\TransferCurrency $transferCurrencies
     */
    public function removeTransferCurrency(\AppBundle\Entity\TransferCurrency $transferCurrencies)
    {
        $this->transferCurrencies->removeElement($transferCurrencies);
    }

    /**
     * Get transferCurrencies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransferCurrencies()
    {
        return $this->transferCurrencies;
    }

    /**
     * Set currencyOrder
     *
     * @param integer $currencyOrder
     * @return Currency
     */
    public function setCurrencyOrder($currencyOrder)
    {
        $this->currencyOrder = $currencyOrder;

        return $this;
    }

    /**
     * Get currencyOrder
     *
     * @return integer 
     */
    public function getCurrencyOrder()
    {
        return $this->currencyOrder;
    }

    /**
     * Add rates
     *
     * @param \AppBundle\Entity\Rate $rates
     * @return Currency
     */
    public function addRate(\AppBundle\Entity\Rate $rates)
    {
        $this->rates[] = $rates;

        return $this;
    }

    /**
     * Remove rates
     *
     * @param \AppBundle\Entity\Rate $rates
     */
    public function removeRate(\AppBundle\Entity\Rate $rates)
    {
        $this->rates->removeElement($rates);
    }

    /**
     * Get rates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\CurrencyTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\CurrencyTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
}
