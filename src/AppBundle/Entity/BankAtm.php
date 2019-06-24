<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * BankAtm
 *
 * @ORM\Table(name="bank_atms")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BankAtmRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\BankAtmTranslation")
 */
class BankAtm extends AbstractPersonalTranslatable implements TranslatableInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Bank", inversedBy="bankAtms")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     * 
     */
    private $bank;
    
    /**
     * @ORM\ManyToOne(targetEntity="ArmRegion", inversedBy="bankAtm")
     * @ORM\JoinColumn(name="arm_region_id", referencedColumnName="arm_region_id")
     * 
     */
    private $armRegion;
    
    /**
     * @ORM\ManyToOne(targetEntity="ArmAdministrative", inversedBy="bankAtms")
     * @ORM\JoinColumn(name="arm_administrative_id", referencedColumnName="arm_administrative_id")
     * 
     */
    private $armAdministrative;
    
    /**
     * @var int
     *
     * @ORM\Column(name="bank_atm_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $bankAtmId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="bank_atm_order", type="integer", nullable=true)
     */
    private $bankAtmOrder;
    
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
     * @ORM\Column(name="bank_atm_address", type="string", length=255, nullable=true)
     */
    private $bankAtmAddress;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="bank_atm_description", type="string", length=255, nullable=true)
     */
    private $bankAtmDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_atm_lat", type="string", length=255, nullable=true)
     */
    private $bankAtmLat;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_atm_long", type="string", length=255, nullable=true)
     */
    private $bankAtmLong;
    
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
     *     targetEntity="AppBundle\Entity\Translation\BankAtmTranslation",
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
     * Get bankAtmId
     *
     * @return integer 
     */
    public function getBankAtmId()
    {
        return $this->bankAtmId;
    }

    /**
     * Set bankAtmOrder
     *
     * @param integer $bankAtmOrder
     * @return BankAtm
     */
    public function setBankAtmOrder($bankAtmOrder)
    {
        $this->bankAtmOrder = $bankAtmOrder;

        return $this;
    }

    /**
     * Get bankAtmOrder
     *
     * @return integer 
     */
    public function getBankAtmOrder()
    {
        return $this->bankAtmOrder;
    }

    /**
     * Set bankAtmAddress
     *
     * @param string $bankAtmAddress
     * @return BankAtm
     */
    public function setBankAtmAddress($bankAtmAddress)
    {
        $this->bankAtmAddress = $bankAtmAddress;

        return $this;
    }

    /**
     * Get bankAtmAddress
     *
     * @return string 
     */
    public function getBankAtmAddress()
    {
        return $this->bankAtmAddress;
    }

    /**
     * Set bankAtmDescription
     *
     * @param string $bankAtmDescription
     * @return BankAtm
     */
    public function setBankAtmDescription($bankAtmDescription)
    {
        $this->bankAtmDescription = $bankAtmDescription;

        return $this;
    }

    /**
     * Get bankAtmDescription
     *
     * @return string 
     */
    public function getBankAtmDescription()
    {
        return $this->bankAtmDescription;
    }

    /**
     * Set bankAtmLat
     *
     * @param string $bankAtmLat
     * @return BankAtm
     */
    public function setBankAtmLat($bankAtmLat)
    {
        $this->bankAtmLat = $bankAtmLat;

        return $this;
    }

    /**
     * Get bankAtmLat
     *
     * @return string 
     */
    public function getBankAtmLat()
    {
        return $this->bankAtmLat;
    }

    /**
     * Set bankAtmLong
     *
     * @param string $bankAtmLong
     * @return BankAtm
     */
    public function setBankAtmLong($bankAtmLong)
    {
        $this->bankAtmLong = $bankAtmLong;

        return $this;
    }

    /**
     * Get bankAtmLong
     *
     * @return string 
     */
    public function getBankAtmLong()
    {
        return $this->bankAtmLong;
    }

    /**
     * Set bank
     *
     * @param \AppBundle\Entity\Bank $bank
     * @return BankAtm
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
     * @return BankAtm
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
     * @return BankAtm
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
     * @return BankAtm
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
     * @return BankAtm
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

    /**
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\BankAtmTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\BankAtmTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
}
