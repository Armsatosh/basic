<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * BankBranch
 *
 * @ORM\Table(name="bank_branches")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BankBranchRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\BankBranchTranslation")
 */
class BankBranch extends AbstractPersonalTranslatable implements TranslatableInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Bank", inversedBy="bankBranches")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     * 
     */
    private $bank;
    
    /**
     * @ORM\ManyToOne(targetEntity="ArmRegion", inversedBy="bankBranches")
     * @ORM\JoinColumn(name="arm_region_id", referencedColumnName="arm_region_id")
     * 
     */
    private $armRegion;
    
    /**
     * @ORM\ManyToOne(targetEntity="ArmAdministrative", inversedBy="bankBranches")
     * @ORM\JoinColumn(name="arm_administrative_id", referencedColumnName="arm_administrative_id")
     * 
     */
    private $armAdministrative;
    
    /**
     * @var int
     *
     * @ORM\Column(name="bank_branch_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $bankBranchId;

    /**
     * @var int
     *
     * @ORM\Column(name="bank_branch_order", type="integer", nullable=true)
     * @ORM\OrderBy({"bankBranchOrder": "ASC"})
     */
    private $bankBranchOrder;
    
    /**
     * @var int
     *
     * @ORM\Column(name="arm_region_id", type="integer", nullable=true)
     */
    private $armRegionId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="arm_administrative_id", type="integer", nullable=true)
     */
    private $armAdministrativeId;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bank_branch_title", type="string", length=255, nullable=true)
     */
    private $bankBranchTitle;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bank_branch_open_hours", type="string", length=255, nullable=true)
     */
    private $bankBranchOpenHours;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bank_branch_address", type="string", length=255, nullable=true)
     */
    private $bankBranchAddress;

    /**
     * @var string
     * @ORM\Column(name="bank_branch_phones", type="array", nullable=true)
     */
    private $bankBranchPhones;

    /**
     * @var string
     * @ORM\Column(name="bank_branch_emails", type="array", nullable=true)
     */
    private $bankBranchEmails;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_branch_lat", type="string", length=255, nullable=true)
     */
    private $bankBranchLat;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_branch_long", type="string", length=255, nullable=true)
     */
    private $bankBranchLong;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_branch_og_image", type="string", length=255, nullable=true)
     */
    private $bankBranchOgImage;

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
     *     targetEntity="AppBundle\Entity\Translation\BankBranchTranslation",
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
     * Get BankBranchId
     *
     * @return integer 
     */
    public function getBankBranchId()
    {
        return $this->bankBranchId;
    }

    /**
     * Set BankBranchOrder
     *
     * @param integer $bankBranchOrder
     * @return BankBranch
     */
    public function setBankBranchOrder($bankBranchOrder)
    {
        $this->bankBranchOrder = $bankBranchOrder;

        return $this;
    }

    /**
     * Get BankBranchOrder
     *
     * @return integer 
     */
    public function getBankBranchOrder()
    {
        return $this->bankBranchOrder;
    }

    /**
     * Set BankBranchTitle
     *
     * @param string $bankBranchTitle
     * @return BankBranch
     */
    public function setBankBranchTitle($bankBranchTitle)
    {
        $this->bankBranchTitle = $bankBranchTitle;

        return $this;
    }

    /**
     * Get BankBranchTitle
     *
     * @return string 
     */
    public function getBankBranchTitle()
    {
        return $this->bankBranchTitle;
    }

    /**
     * Set BankBranchOpenHours
     *
     * @param string $bankBranchOpenHours
     * @return BankBranch
     */
    public function setBankBranchOpenHours($bankBranchOpenHours)
    {
        $this->bankBranchOpenHours = $bankBranchOpenHours;

        return $this;
    }

    /**
     * Get BankBranchOpenHours
     *
     * @return string 
     */
    public function getBankBranchOpenHours()
    {
        return $this->bankBranchOpenHours;
    }

    /**
     * Set BankBranchAddress
     *
     * @param string $bankBranchAddress
     * @return BankBranch
     */
    public function setBankBranchAddress($bankBranchAddress)
    {
        $this->bankBranchAddress = $bankBranchAddress;

        return $this;
    }

    /**
     * Get BankBranchAddress
     *
     * @return string 
     */
    public function getBankBranchAddress()
    {
        return $this->bankBranchAddress;
    }

    /**
     * Set BankBranchPhones
     *
     * @param string $bankBranchPhones
     * @return BankBranch
     */
    public function setBankBranchPhones($bankBranchPhones)
    {
        $this->bankBranchPhones = $bankBranchPhones;

        return $this;
    }

    /**
     * Get BankBranchPhones
     *
     * @return string 
     */
    public function getBankBranchPhones()
    {
        return $this->bankBranchPhones;
    }

    /**
     * Set BankBranchEmails
     *
     * @param string $bankBranchEmails
     * @return BankBranch
     */
    public function setBankBranchEmails($bankBranchEmails)
    {
        $this->bankBranchEmails = $bankBranchEmails;

        return $this;
    }

    /**
     * Get BankBranchEmails
     *
     * @return string 
     */
    public function getBankBranchEmails()
    {
        return $this->bankBranchEmails;
    }

    /**
     * Set BankBranchLat
     *
     * @param string $bankBranchLat
     * @return BankBranch
     */
    public function setBankBranchLat($bankBranchLat)
    {
        $this->bankBranchLat = $bankBranchLat;

        return $this;
    }

    /**
     * Get BankBranchLat
     *
     * @return string 
     */
    public function getBankBranchLat()
    {
        return $this->bankBranchLat;
    }

    /**
     * Set BankBranchLong
     *
     * @param string $bankBranchLong
     * @return BankBranch
     */
    public function setBankBranchLong($bankBranchLong)
    {
        $this->bankBranchLong = $bankBranchLong;

        return $this;
    }

    /**
     * Get BankBranchLong
     *
     * @return string 
     */
    public function getBankBranchLong()
    {
        return $this->bankBranchLong;
    }

    /**
     * Set BankBranchOgImage
     *
     * @param string $bankBranchOgImage
     * @return BankBranch
     */
    public function setBankBranchOgImage($bankBranchOgImage)
    {
        $this->bankBranchOgImage = $bankBranchOgImage;

        return $this;
    }

    /**
     * Get BankBranchOgImage
     *
     * @return string 
     */
    public function getBankBranchOgImage()
    {
        return $this->bankBranchOgImage;
    }

    /**
     * Set bank
     *
     * @param \AppBundle\Entity\Bank $bank
     * @return BankBranch
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
     * Set armRegion
     *
     * @param \AppBundle\Entity\ArmRegion $armRegion
     * @return BankBranch
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
     * @return BankBranch
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

    /**
     * Set armRegionId
     *
     * @param integer $armRegionId
     * @return BankBranch
     */
    public function setArmRegionId($armRegionId)
    {
        $this->armRegionId = $armRegionId;

        return $this;
    }

    /**
     * Get armRegionId
     *
     * @return integer 
     */
    public function getArmRegionId()
    {
        return $this->armRegionId;
    }

    /**
     * Set armAdministrativeId
     *
     * @param integer $armAdministrativeId
     * @return BankBranch
     */
    public function setArmAdministrativeId($armAdministrativeId)
    {
        $this->armAdministrativeId = $armAdministrativeId;

        return $this;
    }

    /**
     * Get armAdministrativeId
     *
     * @return integer 
     */
    public function getArmAdministrativeId()
    {
        return $this->armAdministrativeId;
    }
    
    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        
        return 'img/bank-branches/uploads/'.$this->getBankBranchId();
    }

    public function getAbsolutePath()
    {
        
        return null === $this->bankBranchOgImage ? null : $this->getUploadRootDir().'/'.$this->bankBranchOgImage;
        
    }

    public function getWebPath()
    {
        
        return null === $this->bankBranchOgImage ? null : $this->getUploadDir().'/'.$this->bankBranchOgImage;

    }
    

    /**
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\BankBranchTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\BankBranchTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
}
