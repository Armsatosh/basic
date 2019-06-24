<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CreditCompany
 *
 * @ORM\Table(name="credit_companies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CreditCompanyRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CreditCompanyTranslation")
 */
class CreditCompany extends AbstractPersonalTranslatable implements TranslatableInterface
{
    
    /**
     * @ORM\OneToMany(targetEntity="CreditCompanyBranch", mappedBy="creditCompany", cascade={"all"})
     */
    private $creditCompanyBranches;
    
    /**
     * @var int
     *
     * @ORM\Column(name="credit_company_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $creditCompanyId;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_order", type="string", length=255, nullable=true)
     */
    private $creditCompanyOrder;

    /**
     * @var string
     * @Gedmo\Slug(fields={"creditCompanyTitle"}, updatable=true, separator="-")
     * @ORM\Column(name="credit_company_slug", type="string", length=255, nullable=true)
     */
    private $creditCompanySlug;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="credit_company_title", type="string", length=255, nullable=true)
     */
    private $creditCompanyTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_tin_number", type="string", length=255, nullable=true)
     */
    private $creditCompanyTinNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_link", type="string", length=255, nullable=true)
     */
    private $creditCompanyLink;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_logo", type="string", length=255, nullable=true)
     */
    private $creditCompanyLogo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_map_marker", type="string", length=255, nullable=true)
     */
    private $creditCompanyMapMarker;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="credit_company_meta_keywords", type="string", length=255, nullable=true)
     */
    private $creditCompanyMetaKeywords;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="credit_company_meta_description", type="string", length=255, nullable=true)
     */
    private $creditCompanyMetaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_og_image", type="string", length=255, nullable=true)
     */
    private $creditCompanyOgImage;
    
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
     *     targetEntity="AppBundle\Entity\Translation\CreditCompanyTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;
    
    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->creditCompanyBranches = new ArrayCollection();
    }
    
    /**
     * Get creditCompanyId
     *
     * @return integer 
     */
    public function creditCompanyId()
    {
        return $this->creditCompanyId;
    }

    /**
     * Set creditCompanyOrder
     *
     * @param string $creditCompanyOrder
     * @return CreditCompany
     */
    public function setCreditCompanyOrder($creditCompanyOrder)
    {
        $this->creditCompanyOrder = $creditCompanyOrder;

        return $this;
    }

    /**
     * Get creditCompanyOrder
     *
     * @return string 
     */
    public function getCreditCompanyOrder()
    {
        return $this->creditCompanyOrder;
    }

    /**
     * Set creditCompanySlug
     *
     * @param string $creditCompanySlug
     * @return CreditCompany
     */
    public function setCreditCompanySlug($creditCompanySlug)
    {
        $this->creditCompanySlug = $creditCompanySlug;

        return $this;
    }

    /**
     * Get creditCompanySlug
     *
     * @return string 
     */
    public function getCreditCompanySlug()
    {
        return $this->creditCompanySlug;
    }

    /**
     * Set creditCompanyTitle
     *
     * @param string $creditCompanyTitle
     * @return CreditCompany
     */
    public function setCrefitCompanyTitle($creditCompanyTitle)
    {
        $this->creditCompanyTitle = $creditCompanyTitle;

        return $this;
    }

    /**
     * Get creditCompanyTitle
     *
     * @return string 
     */
    public function getCrefitCompanyTitle()
    {
        return $this->creditCompanyTitle;
    }

    /**
     * Set creditCompanyTinNumbe
     *
     * @param integer $creditCompanyTinNumbe
     * @return CreditCompany
     */
    public function setCreditCompanyTinNumbe($creditCompanyTinNumbe)
    {
        $this->creditCompanyTinNumbe = $creditCompanyTinNumbe;

        return $this;
    }

    /**
     * Get creditCompanyTinNumbe
     *
     * @return integer 
     */
    public function getCreditCompanyTinNumbe()
    {
        return $this->creditCompanyTinNumbe;
    }

    /**
     * Set creditCompanyLink
     *
     * @param string $creditCompanyLink
     * @return CreditCompany
     */
    public function setCreditCompanyLink($creditCompanyLink)
    {
        $this->creditCompanyLink = $creditCompanyLink;

        return $this;
    }

    /**
     * Get creditCompanyLink
     *
     * @return string 
     */
    public function getCreditCompanyLink()
    {
        return $this->creditCompanyLink;
    }

    /**
     * Set creditCompanyLogo
     *
     * @param string $creditCompanyLogo
     * @return CreditCompany
     */
    public function setCreditCompanyLogo($creditCompanyLogo)
    {
        $this->creditCompanyLogo = $creditCompanyLogo;

        return $this;
    }

    /**
     * Get creditCompanyLogo
     *
     * @return string 
     */
    public function getCreditCompanyLogo()
    {
        return $this->creditCompanyLogo;
    }
    
    /**
     * Set creditCompanyMapMarker
     *
     * @param string $creditCompanyMapMarker
     * @return CreditCompany
     */
    public function setCreditCompanyMapMarker($creditCompanyMapMarker)
    {
        $this->creditCompanyMapMarker = $creditCompanyMapMarker;

        return $this;
    }

    /**
     * Get creditCompanyMapMarker
     *
     * @return string 
     */
    public function getCreditCompanyMapMarker()
    {
        return $this->creditCompanyMapMarker;
    }
    
    /**
     * Set creditCompanyMetaKeywords
     *
     * @param string $creditCompanyMetaKeywords
     * @return CreditCompany
     */
    public function setCreditCompanyMetaKeywords($creditCompanyMetaKeywords)
    {
        $this->creditCompanyMetaKeywords = $creditCompanyMetaKeywords;

        return $this;
    }

    /**
     * Get creditCompanyMetaKeywords
     *
     * @return string 
     */
    public function getCreditCompanyMetaKeywords()
    {
        return $this->creditCompanyMetaKeywords;
    }

    /**
     * Set creditCompanyMetaDescription
     *
     * @param string $creditCompanyMetaDescription
     * @return CreditCompany
     */
    public function setCreditCompanyMetaDescription($creditCompanyMetaDescription)
    {
        $this->creditCompanyMetaDescription = $creditCompanyMetaDescription;

        return $this;
    }

    /**
     * Get creditCompanyMetaDescription
     *
     * @return string 
     */
    public function getCreditCompanyMetaDescription()
    {
        return $this->creditCompanyMetaDescription;
    }

    /**
     * Set creditCompanyOgImage
     *
     * @param string $creditCompanyOgImage
     * @return CreditCompany
     */
    public function setCreditCompanyOgImage($creditCompanyOgImage)
    {
        $this->creditCompanyOgImage = $creditCompanyOgImage;

        return $this;
    }

    /**
     * Get creditCompanyOgImage
     *
     * @return string 
     */
    public function getCreditCompanyOgImage()
    {
        return $this->creditCompanyOgImage;
    }

    /**
     * Set creditCompanyTitle
     *
     * @param string $creditCompanyTitle
     * @return CreditCompany
     */
    public function setCreditCompanyTitle($creditCompanyTitle)
    {
        $this->creditCompanyTitle = $creditCompanyTitle;

        return $this;
    }

    /**
     * Get creditCompanyTitle
     *
     * @return string 
     */
    public function getCreditCompanyTitle()
    {
        return $this->creditCompanyTitle;
    }

    /**
     * Set creditCompanyTinNumber
     *
     * @param integer $creditCompanyTinNumber
     * @return CreditCompany
     */
    public function setCreditCompanyTinNumber($creditCompanyTinNumber)
    {
        $this->creditCompanyTinNumber = $creditCompanyTinNumber;

        return $this;
    }

    /**
     * Get creditCompanyTinNumber
     *
     * @return integer 
     */
    public function getCreditCompanyTinNumber()
    {
        return $this->creditCompanyTinNumber;
    }

    /**
     * Add creditCompanyBranches
     *
     * @param \AppBundle\Entity\CreditCompanyBranch $creditCompanyBranches
     * @return CreditCompany
     */
    public function addCreditCompanyBranch(\AppBundle\Entity\CreditCompanyBranch $creditCompanyBranches)
    {
        $this->creditCompanyBranches[] = $creditCompanyBranches;

        return $this;
    }

    /**
     * Remove creditCompanyBranches
     *
     * @param \AppBundle\Entity\CreditCompanyBranch $creditCompanyBranches
     */
    public function removeCreditCompanyBranch(\AppBundle\Entity\CreditCompanyBranch $creditCompanyBranches)
    {
        $this->creditCompanyBranches->removeElement($creditCompanyBranches);
    }

    /**
     * Get creditCompanyBranches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreditCompanyBranches()
    {
        return $this->creditCompanyBranches;
    }
    
    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        
        return 'img/credit-companies/uploads/'.$this->creditCompanyId();
    }

    public function getAbsolutePath()
    {
        
        return null === $this->creditCompanyOgImage ? null : $this->getUploadRootDir().'/'.$this->creditCompanyOgImage;
        
    }

    public function getWebPath()
    {
        
        return null === $this->creditCompanyOgImage ? null : $this->getUploadDir().'/'.$this->creditCompanyOgImage;

    }
    

    /**
     * Get creditCompanyId
     *
     * @return integer 
     */
    public function getCreditCompanyId()
    {
        return $this->creditCompanyId;
    }

    /**
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\CreditCompanyTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\CreditCompanyTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
    
}
