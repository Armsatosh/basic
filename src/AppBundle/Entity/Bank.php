<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Bank
 *
 * @ORM\Table(name="banks")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BankRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\BankTranslation")
 */
class Bank extends AbstractPersonalTranslatable implements TranslatableInterface
{
    /**
     * @ORM\OneToMany(targetEntity="BankBranch", mappedBy="bank", cascade={"all"})
     */
    private $bankBranches;
    
    /**
     * @ORM\OneToMany(targetEntity="BankAtm", mappedBy="bank", cascade={"all"})
     */
    private $bankAtms;
    
    /**
     * @ORM\OneToMany(targetEntity="Loan", mappedBy="bank", cascade={"all"})
     */
    private $loans;
    
    /**
     * @ORM\OneToMany(targetEntity="Deposit", mappedBy="bank", cascade={"all"})
     */
    private $deposits;
    
    /**
     * @ORM\OneToMany(targetEntity="Transfer", mappedBy="bank", cascade={"all"})
     */
    private $transfers;
    
    /**
     * @ORM\OneToMany(targetEntity="EwalletRate", mappedBy="bank", cascade={"all"})
     */
    private $ewalletRates;
    
    /**
     * @ORM\OneToMany(targetEntity="Rate", mappedBy="bank", cascade={"all"})
     */
    private $rates;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RateCurrent", mappedBy="bank", cascade={"all"})
     */
    private $rateCurrent;
    
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
     *     targetEntity="AppBundle\Entity\Translation\BankTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;
    
    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->bankBranches = new ArrayCollection();
        $this->bankAtms = new ArrayCollection();
        $this->rates = new ArrayCollection();
        $this->loans = new ArrayCollection();
        $this->deposits = new ArrayCollection();
        $this->transfers = new ArrayCollection();
        $this->ewalletRates = new ArrayCollection();
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="bank_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $bankId;

    /**
     * @var int
     *
     * @ORM\Column(name="bank_order", type="integer", nullable=true)
     */
    private $bankOrder;

    /**
     * @var string
     * @ORM\Column(name="bank_slug", type="string", length=255)
     */
    private $bankSlug;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bank_title", type="string", length=255)
     */
    private $bankTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_tin_number", type="string", length=255, nullable=true)
     */
    private $bankTinNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_swift_code", type="string", length=255, nullable=true)
     */
    private $bankSwiftCode;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_link", type="string", length=2000, nullable=true)
     */
    private $bankLink;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_link_branches", type="string", length=2000, nullable=true)
     */
    private $bankLinkBranches;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_link_atms", type="string", length=2000, nullable=true)
     */
    private $bankLinkAtms;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_logo", type="string", length=255, nullable=true)
     */
    private $bankLogo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="bank_map_marker", type="string", length=255, nullable=true)
     */
    private $bankMapMarker;
    
    /**
     * @var string
     *
     * @ORM\Column(name="bank_rate_link", type="string", length=2000, nullable=true)
     */
    private $bankRateLink;
    
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bank_meta_keywords", type="string", length=255, nullable=true)
     */
    private $bankMetaKeywords;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bank_meta_description", type="string", length=255, nullable=true)
     */
    private $bankMetaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_og_image", type="string", length=255, nullable=true)
     */
    private $bankOgImage;

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
     * Set bankOrder
     *
     * @param integer $bankOrder
     * @return Bank
     */
    public function setBankOrder($bankOrder)
    {
        $this->bankOrder = $bankOrder;

        return $this;
    }

    /**
     * Get bankOrder
     *
     * @return integer 
     */
    public function getBankOrder()
    {
        return $this->bankOrder;
    }

    /**
     * Set bankSlug
     *
     * @param string $bankSlug
     * @return Bank
     */
    public function setBankSlug($bankSlug)
    {
        $this->bankSlug = $bankSlug;

        return $this;
    }

    /**
     * Get bankSlug
     *
     * @return string 
     */
    public function getBankSlug()
    {
        return $this->bankSlug;
    }

    /**
     * Set bankTitle
     *
     * @param string $bankTitle
     * @return Bank
     */
    public function setBankTitle($bankTitle)
    {
        $this->bankTitle = $bankTitle;

        return $this;
    }

    /**
     * Get bankTitle
     *
     * @return string 
     */
    public function getBankTitle()
    {
        return $this->bankTitle;
    }

    /**
     * Set bankTinNumber
     *
     * @param integer $bankTinNumber
     * @return Bank
     */
    public function setBankTinNumber($bankTinNumber)
    {
        $this->bankTinNumber = $bankTinNumber;

        return $this;
    }

    /**
     * Get bankTinNumber
     *
     * @return integer 
     */
    public function getBankTinNumber()
    {
        return $this->bankTinNumber;
    }

    /**
     * Set bankSwiftCode
     *
     * @param string $bankSwiftCode
     * @return Bank
     */
    public function setBankSwiftCode($bankSwiftCode)
    {
        $this->bankSwiftCode = $bankSwiftCode;

        return $this;
    }

    /**
     * Get bankSwiftCode
     *
     * @return string 
     */
    public function getBankSwiftCode()
    {
        return $this->bankSwiftCode;
    }

    /**
     * Set bankLink
     *
     * @param string $bankLink
     * @return Bank
     */
    public function setBankLink($bankLink)
    {
        $this->bankLink = $bankLink;

        return $this;
    }

    /**
     * Get bankLink
     *
     * @return string 
     */
    public function getBankLink()
    {
        return $this->bankLink;
    }

    /**
     * Set bankLinkBranches
     *
     * @param string $bankLinkBranches
     * @return Bank
     */
    public function setBankLinkBranches($bankLinkBranches)
    {
        $this->bankLinkBranches = $bankLinkBranches;

        return $this;
    }

    /**
     * Get bankLinkBranches
     *
     * @return string 
     */
    public function getBankLinkBranches()
    {
        return $this->bankLinkBranches;
    }

    /**
     * Set bankLinkAtms
     *
     * @param string $bankLinkAtms
     * @return Bank
     */
    public function setBankLinkAtms($bankLinkAtms)
    {
        $this->bankLinkAtms = $bankLinkAtms;

        return $this;
    }

    /**
     * Get bankLinkAtms
     *
     * @return string 
     */
    public function getBankLinkAtms()
    {
        return $this->bankLinkAtms;
    }

    /**
     * Set bankLogo
     *
     * @param string $bankLogo
     * @return Bank
     */
    public function setBankLogo($bankLogo)
    {
        $this->bankLogo = $bankLogo;

        return $this;
    }

    /**
     * Get bankLogo
     *
     * @return string 
     */
    public function getBankLogo()
    {
        return $this->bankLogo;
    }
    
    /**
     * Set bankMapMarker
     *
     * @param string $bankMapMarker
     * @return Bank
     */
    public function setBankMapMarker($bankMapMarker)
    {
        $this->bankMapMarker = $bankMapMarker;

        return $this;
    }

    /**
     * Get bankMapMarker
     *
     * @return string 
     */
    public function getBankMapMarker()
    {
        return $this->bankMapMarker;
    }

    /**
     * Set bankMetaKeywords
     *
     * @param string $bankMetaKeywords
     * @return Bank
     */
    public function setBankMetaKeywords($bankMetaKeywords)
    {
        $this->bankMetaKeywords = $bankMetaKeywords;

        return $this;
    }

    /**
     * Get bankMetaKeywords
     *
     * @return string 
     */
    public function getBankMetaKeywords()
    {
        return $this->bankMetaKeywords;
    }

    /**
     * Set bankMetaDescription
     *
     * @param string $bankMetaDescription
     * @return Bank
     */
    public function setBankMetaDescription($bankMetaDescription)
    {
        $this->bankMetaDescription = $bankMetaDescription;

        return $this;
    }

    /**
     * Get bankMetaDescription
     *
     * @return string 
     */
    public function getBankMetaDescription()
    {
        return $this->bankMetaDescription;
    }

    /**
     * Set bankOgImage
     *
     * @param string $bankOgImage
     * @return Bank
     */
    public function setBankOgImage($bankOgImage)
    {
        $this->bankOgImage = $bankOgImage;

        return $this;
    }

    /**
     * Get bankOgImage
     *
     * @return string 
     */
    public function getBankOgImage()
    {
        return $this->bankOgImage;
    }

    /**
     * Add bankBranches
     *
     * @param \AppBundle\Entity\BankBranch $bankBranches
     * @return Bank
     */
    public function addBankBranch(\AppBundle\Entity\BankBranch $bankBranches)
    {
        $this->bankBranches[] = $bankBranches;

        return $this;
    }

    /**
     * Remove bankBranches
     *
     * @param \AppBundle\Entity\BankBranch $bankBranches
     */
    public function removeBankBranch(\AppBundle\Entity\BankBranch $bankBranches)
    {
        $this->bankBranches->removeElement($bankBranches);
    }

    /**
     * Get bankBranches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBankBranches()
    {
        return $this->bankBranches;
    }

    /**
     * Add bankAtms
     *
     * @param \AppBundle\Entity\BankAtm $bankAtms
     * @return Bank
     */
    public function addBankAtm(\AppBundle\Entity\BankAtm $bankAtms)
    {
        $this->bankAtms[] = $bankAtms;

        return $this;
    }

    /**
     * Remove bankAtms
     *
     * @param \AppBundle\Entity\BankAtm $bankAtms
     */
    public function removeBankAtm(\AppBundle\Entity\BankAtm $bankAtms)
    {
        $this->bankAtms->removeElement($bankAtms);
    }

    /**
     * Get bankAtms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBankAtms()
    {
        return $this->bankAtms;
    }

    /**
     * Add loans
     *
     * @param \AppBundle\Entity\Loan $loans
     * @return Bank
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
     * @return Bank
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
     * Add transfers
     *
     * @param \AppBundle\Entity\Transfer $transfers
     * @return Bank
     */
    public function addTransfer(\AppBundle\Entity\Transfer $transfers)
    {
        $this->transfers[] = $transfers;

        return $this;
    }

    /**
     * Remove transfers
     *
     * @param \AppBundle\Entity\Transfer $transfers
     */
    public function removeTransfer(\AppBundle\Entity\Transfer $transfers)
    {
        $this->transfers->removeElement($transfers);
    }

    /**
     * Get transfers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransfers()
    {
        return $this->transfers;
    }

    /**
     * Add ewalletRates
     *
     * @param \AppBundle\Entity\EwalletRate $ewalletRates
     * @return Bank
     */
    public function addEwalletRate(\AppBundle\Entity\EwalletRate $ewalletRates)
    {
        $this->ewalletRates[] = $ewalletRates;

        return $this;
    }

    /**
     * Remove ewalletRates
     *
     * @param \AppBundle\Entity\EwalletRate $ewalletRates
     */
    public function removeEwalletRate(\AppBundle\Entity\EwalletRate $ewalletRates)
    {
        $this->ewalletRates->removeElement($ewalletRates);
    }

    /**
     * Get ewalletRates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEwalletRates()
    {
        return $this->ewalletRates;
    }

    /**
     * Set bankRateLink
     *
     * @param string $bankRateLink
     * @return Bank
     */
    public function setBankRateLink($bankRateLink)
    {
        $this->bankRateLink = $bankRateLink;

        return $this;
    }

    /**
     * Get bankRateLink
     *
     * @return string 
     */
    public function getBankRateLink()
    {
        return $this->bankRateLink;
    }

    /**
     * Add rates
     *
     * @param \AppBundle\Entity\Rate $rates
     * @return Bank
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
     * @return mixed
     */
    public function getRateCurrent()
    {
        return $this->rateCurrent;
    }

    /**
     * @param mixed $rateCurrent
     */
    public function setRateCurrent($rateCurrent)
    {
        $this->rateCurrent = $rateCurrent;
    }

    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        
        return 'img/banks/uploads/'.$this->getBankId();
    }

    public function getAbsolutePath()
    {
        
        return null === $this->bankOgImage ? null : $this->getUploadRootDir().'/'.$this->bankOgImage;
        
    }

    public function getWebPath()
    {
        
        return null === $this->bankOgImage ? null : $this->getUploadDir().'/'.$this->bankOgImage;

    }
    

    /**
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\BankTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\BankTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }

    
}
