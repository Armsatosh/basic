<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CreditCompanyBranch
 *
 * @ORM\Table(name="credit_company_branches")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CreditCompanyBranchRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CreditCompanyBranchTranslation")
 */
class CreditCompanyBranch extends AbstractPersonalTranslatable implements TranslatableInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="CreditCompany", inversedBy="creditCompanyBranches")
     * @ORM\JoinColumn(name="credit_company_id", referencedColumnName="credit_company_id")
     * 
     */
    private $creditCompany;
    
    /**
     * @ORM\ManyToOne(targetEntity="ArmRegion", inversedBy="creditCompanyBranches")
     * @ORM\JoinColumn(name="arm_region_id", referencedColumnName="arm_region_id")
     * 
     */
    private $armRegion;
    
    /**
     * @ORM\ManyToOne(targetEntity="ArmAdministrative", inversedBy="creditCompanyBranches")
     * @ORM\JoinColumn(name="arm_administrative_id", referencedColumnName="arm_administrative_id")
     * 
     */
    private $armAdministrative;
    
    /**
     * @var int
     *
     * @ORM\Column(name="credit_company_branch_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $creditCompanyBranchId;

    /**
     * @var int
     *
     * @ORM\Column(name="credit_company_branch_order", type="integer", nullable=true)
     */
    private $creditCompanyBranchOrder;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="credit_company_branch_title", type="string", length=255, nullable=true)
     */
    private $creditCompanyBranchTitle;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="credit_company_branch_open_hours", type="text", nullable=true)
     */
    private $creditCompanyBranchOpenHours;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="credit_company_branch_address", type="text", nullable=true)
     */
    private $creditCompanyBranchAddress;

    /**
     * @var string
     * @ORM\Column(name="credit_company_branch_phones", type="array", nullable=true)
     */
    private $creditCompanyBranchPhones;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_branch_emails", type="array", nullable=true)
     */
    private $creditCompanyBranchEmails;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_branch_lat", type="string", length=255, nullable=true)
     */
    private $creditCompanyBranchLat;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_branch_long", type="string", length=255, nullable=true)
     */
    private $creditCompanyBranchLong;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_company_branch_og_image", type="string", length=255, nullable=true)
     */
    private $creditCompanyBranchOgImage;
    
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
     *     targetEntity="AppBundle\Entity\Translation\CreditCompanyBranchTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;
    
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }
    
    /**
     * Get creditCompanyBranchId
     *
     * @return integer 
     */
    public function getCreditCompanyBranchId()
    {
        return $this->creditCompanyBranchId;
    }

    /**
     * Set creditCompanyBranchOrder
     *
     * @param integer $creditCompanyBranchOrder
     * @return CreditCompanyBranch
     */
    public function setCreditCompanyBranchOrder($creditCompanyBranchOrder)
    {
        $this->creditCompanyBranchOrder = $creditCompanyBranchOrder;

        return $this;
    }

    /**
     * Get creditCompanyBranchOrder
     *
     * @return integer 
     */
    public function getCreditCompanyBranchOrder()
    {
        return $this->creditCompanyBranchOrder;
    }

    /**
     * Set creditCompanyBranchTitle
     *
     * @param string $creditCompanyBranchTitle
     * @return CreditCompanyBranch
     */
    public function setCreditCompanyBranchTitle($creditCompanyBranchTitle)
    {
        $this->creditCompanyBranchTitle = $creditCompanyBranchTitle;

        return $this;
    }

    /**
     * Get creditCompanyBranchTitle
     *
     * @return string 
     */
    public function getCreditCompanyBranchTitle()
    {
        return $this->creditCompanyBranchTitle;
    }

    /**
     * Set creditCompanyBranchOpenHours
     *
     * @param string $creditCompanyBranchOpenHours
     * @return CreditCompanyBranch
     */
    public function setCreditCompanyBranchOpenHours($creditCompanyBranchOpenHours)
    {
        $this->creditCompanyBranchOpenHours = $creditCompanyBranchOpenHours;

        return $this;
    }

    /**
     * Get creditCompanyBranchOpenHours
     *
     * @return string 
     */
    public function getCreditCompanyBranchOpenHours()
    {
        return $this->creditCompanyBranchOpenHours;
    }

    /**
     * Set creditCompanyBranchAddress
     *
     * @param string $creditCompanyBranchAddress
     * @return CreditCompanyBranch
     */
    public function setCreditCompanyBranchAddress($creditCompanyBranchAddress)
    {
        $this->creditCompanyBranchAddress = $creditCompanyBranchAddress;

        return $this;
    }

    /**
     * Get creditCompanyBranchAddress
     *
     * @return string 
     */
    public function getCreditCompanyBranchAddress()
    {
        return $this->creditCompanyBranchAddress;
    }

    /**
     * Set creditCompanyBranchPhones
     *
     * @param string $creditCompanyBranchPhones
     * @return CreditCompanyBranch
     */
    public function setCreditCompanyBranchPhones($creditCompanyBranchPhones)
    {
        $this->creditCompanyBranchPhones = $creditCompanyBranchPhones;

        return $this;
    }

    /**
     * Get creditCompanyBranchPhones
     *
     * @return string 
     */
    public function getCreditCompanyBranchPhones()
    {
        return $this->creditCompanyBranchPhones;
    }

    /**
     * Set creditCompanyBranchEmails
     *
     * @param string $creditCompanyBranchEmails
     * @return CreditCompanyBranch
     */
    public function setCreditCompanyBranchEmails($creditCompanyBranchEmails)
    {
        $this->creditCompanyBranchEmails = $creditCompanyBranchEmails;

        return $this;
    }

    /**
     * Get creditCompanyBranchEmails
     *
     * @return string 
     */
    public function getCreditCompanyBranchEmails()
    {
        return $this->creditCompanyBranchEmails;
    }

    /**
     * Set creditCompanyBranchLat
     *
     * @param string $creditCompanyBranchLat
     * @return CreditCompanyBranch
     */
    public function setCreditCompanyBranchLat($creditCompanyBranchLat)
    {
        $this->creditCompanyBranchLat = $creditCompanyBranchLat;

        return $this;
    }

    /**
     * Get creditCompanyBranchLat
     *
     * @return string 
     */
    public function getCreditCompanyBranchLat()
    {
        return $this->creditCompanyBranchLat;
    }

    /**
     * Set creditCompanyBranchLong
     *
     * @param string $creditCompanyBranchLong
     * @return CreditCompanyBranch
     */
    public function setCreditCompanyBranchLong($creditCompanyBranchLong)
    {
        $this->creditCompanyBranchLong = $creditCompanyBranchLong;

        return $this;
    }

    /**
     * Get creditCompanyBranchLong
     *
     * @return string 
     */
    public function getCreditCompanyBranchLong()
    {
        return $this->creditCompanyBranchLong;
    }

    /**
     * Set creditCompanyBranchOgImage
     *
     * @param string $creditCompanyBranchOgImage
     * @return CreditCompanyBranch
     */
    public function setCreditCompanyBranchOgImage($creditCompanyBranchOgImage)
    {
        $this->creditCompanyBranchOgImage = $creditCompanyBranchOgImage;

        return $this;
    }

    /**
     * Get creditCompanyBranchOgImage
     *
     * @return string 
     */
    public function getCreditCompanyBranchOgImage()
    {
        return $this->creditCompanyBranchOgImage;
    }

    /**
     * Set creditCompany
     *
     * @param \AppBundle\Entity\CreditCompany $creditCompany
     * @return CreditCompanyBranch
     */
    public function setCreditCompany(\AppBundle\Entity\CreditCompany $creditCompany = null)
    {
        $this->creditCompany = $creditCompany;

        return $this;
    }

    /**
     * Get creditCompany
     *
     * @return \AppBundle\Entity\CreditCompany 
     */
    public function getCreditCompany()
    {
        return $this->creditCompany;
    }

    /**
     * Set armRegion
     *
     * @param \AppBundle\Entity\ArmRegion $armRegion
     * @return CreditCompanyBranch
     */
    public function setArmRegion(\AppBundle\Entity\ArmRegion $armRegion = null)
    {
        $this->armRegion = $armRegion;

        return $this;
    }

    /**
     * Get armRegion
     *
     * @return \AppBundle\Entity\ArmRegion 
     */
    public function getArmRegion()
    {
        return $this->armRegion;
    }

    /**
     * Set armAdministrative
     *
     * @param \AppBundle\Entity\ArmAdministrative $armAdministrative
     * @return CreditCompanyBranch
     */
    public function setArmAdministrative(\AppBundle\Entity\ArmAdministrative $armAdministrative = null)
    {
        $this->armAdministrative = $armAdministrative;

        return $this;
    }

    /**
     * Get armAdministrative
     *
     * @return \AppBundle\Entity\ArmAdministrative 
     */
    public function getArmAdministrative()
    {
        return $this->armAdministrative;
    }
    
    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        
        return 'img/credit-company-branch/uploads/'.$this->getCreditCompanyBranchId();
    }

    public function getAbsolutePath()
    {
        
        return null === $this->creditCompanyBranchOgImage ? null : $this->getUploadRootDir().'/'.$this->creditCompanyBranchOgImage;
        
    }

    public function getWebPath()
    {
        
        return null === $this->creditCompanyBranchOgImage ? null : $this->getUploadDir().'/'.$this->creditCompanyBranchOgImage;

    }
    

    /**
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\CreditCompanyBranchTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\CreditCompanyBranchTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
}
