<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Transfer
 *
 * @ORM\Table(name="transfers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransferRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\TransferTranslation")
 */
class Transfer extends AbstractPersonalTranslatable implements TranslatableInterface
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Bank", inversedBy="transfers")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     * 
     */
    private $bank;
    
    /**
     * @ORM\ManyToOne(targetEntity="TransferType", inversedBy="transfers")
     * @ORM\JoinColumn(name="transfer_type_id", referencedColumnName="transfer_type_id")
     * 
     */
    private $transferType;
    
    /**
     * @ORM\OneToMany(targetEntity="TransferCurrency", mappedBy="transfer")
     */
    private $transferCurrencies;
    
    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->transferCurrencies = new ArrayCollection();
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $transferId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_type_id", type="integer", nullable=true)
     */
    private $transferTypeId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="bank_id", type="integer", nullable=true)
     */
    private $bankId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_order", type="integer", nullable=true)
     */
    private $transferOrder;

    /**
     * @var float
     *
     * @ORM\Column(name="transfer_com_min", type="float", nullable=true)
     */
    private $transferComMin;
    
    /**
     * @var float
     *
     * @ORM\Column(name="transfer_com_max", type="float", nullable=true)
     */
    private $transferComMax;

    /**
     * @var float
     *
     * @ORM\Column(name="transfer_com_percent", type="float", nullable=true)
     */
    private $transferComPercent;
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_speed_minute", type="integer", nullable=true)
     */
    private $transferSpeedMinute;
    
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="transfer_other_conditions", type="text", nullable=true)
     */
    private $transferOtherConditions;
    
    /**
     * @var string
     *
     * @ORM\Column(name="transfer_link", type="string", length=255, nullable=true)
     */
    private $transferLink;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="transfer_description", type="text", nullable=true)
     */
    private $transferDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transfer_update_date", type="datetime", nullable=true)
     */
    private $transferUpdateDate;
    
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
     *     targetEntity="AppBundle\Entity\Translation\TransferTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;
    
    
    
    /**
     * Get transferId
     *
     * @return integer 
     */
    public function getTransferId()
    {
        return $this->transferId;
    }

    /**
     * Set transferOrder
     *
     * @param integer $transferOrder
     * @return Transfer
     */
    public function setTransferOrder($transferOrder)
    {
        $this->transferOrder = $transferOrder;

        return $this;
    }

    /**
     * Get transferOrder
     *
     * @return integer 
     */
    public function getTransferOrder()
    {
        return $this->transferOrder;
    }

    /**
     * Set transferComMin
     *
     * @param float $transferComMin
     * @return Transfer
     */
    public function setTransferComMin($transferComMin)
    {
        $this->transferComMin = $transferComMin;

        return $this;
    }

    /**
     * Get transferComMin
     *
     * @return float 
     */
    public function getTransferComMin()
    {
        return $this->transferComMin;
    }

    /**
     * Set transferComPercent
     *
     * @param float $transferComPercent
     * @return Transfer
     */
    public function setTransferComPercent($transferComPercent)
    {
        $this->transferComPercent = $transferComPercent;

        return $this;
    }

    /**
     * Get transferComPercent
     *
     * @return float 
     */
    public function getTransferComPercent()
    {
        return $this->transferComPercent;
    }

    /**
     * Set transferLink
     *
     * @param string $transferLink
     * @return Transfer
     */
    public function setTransferLink($transferLink)
    {
        $this->transferLink = $transferLink;

        return $this;
    }

    /**
     * Get transferLink
     *
     * @return string 
     */
    public function getTransferLink()
    {
        return $this->transferLink;
    }

    /**
     * Set transferDescription
     *
     * @param string $transferDescription
     * @return Transfer
     */
    public function setTransferDescription($transferDescription)
    {
        $this->transferDescription = $transferDescription;

        return $this;
    }

    /**
     * Get transferDescription
     *
     * @return string 
     */
    public function getTransferDescription()
    {
        return $this->transferDescription;
    }

    /**
     * Set transferUpdateDate
     *
     * @param \DateTime $transferUpdateDate
     * @return Transfer
     */
    public function setTransferUpdateDate($transferUpdateDate)
    {
        $this->transferUpdateDate = $transferUpdateDate;

        return $this;
    }

    /**
     * Get transferUpdateDate
     *
     * @return \DateTime 
     */
    public function getTransferUpdateDate()
    {
        return $this->transferUpdateDate;
    }

    /**
     * Set transferType
     *
     * @param \AppBundle\Entity\TransferType $transferType
     * @return Transfer
     */
    public function setTransferType(\AppBundle\Entity\TransferType $transferType = null)
    {
        $this->transferType = $transferType;

        return $this;
    }

    /**
     * Get transferType
     *
     * @return \AppBundle\Entity\TransferType 
     */
    public function getTransferType()
    {
        return $this->transferType;
    }

    /**
     * Add transferCurrencies
     *
     * @param \AppBundle\Entity\TransferCurrency $transferCurrencies
     * @return Transfer
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
     * Set transferSpeedMinute
     *
     * @param integer $transferSpeedMinute
     * @return Transfer
     */
    public function setTransferSpeedMinute($transferSpeedMinute)
    {
        $this->transferSpeedMinute = $transferSpeedMinute;

        return $this;
    }

    /**
     * Get transferSpeedMinute
     *
     * @return integer 
     */
    public function getTransferSpeedMinute()
    {
        return $this->transferSpeedMinute;
    }

    /**
     * Set bankId
     *
     * @param integer $bankId
     * @return Transfer
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
     * Set transferTypeId
     *
     * @param integer $transferTypeId
     * @return Transfer
     */
    public function setTransferTypeId($transferTypeId)
    {
        $this->transferTypeId = $transferTypeId;

        return $this;
    }

    /**
     * Get transferTypeId
     *
     * @return integer 
     */
    public function getTransferTypeId()
    {
        return $this->transferTypeId;
    }

    /**
     * Set transferOtherConditions
     *
     * @param string $transferOtherConditions
     * @return Transfer
     */
    public function setTransferOtherConditions($transferOtherConditions)
    {
        $this->transferOtherConditions = $transferOtherConditions;

        return $this;
    }

    /**
     * Get transferOtherConditions
     *
     * @return string 
     */
    public function getTransferOtherConditions()
    {
        return $this->transferOtherConditions;
    }

    /**
     * Set transferComMax
     *
     * @param float $transferComMax
     * @return Transfer
     */
    public function setTransferComMax($transferComMax)
    {
        $this->transferComMax = $transferComMax;

        return $this;
    }

    /**
     * Get transferComMax
     *
     * @return float 
     */
    public function getTransferComMax()
    {
        return $this->transferComMax;
    }

    /**
     * Set bank
     *
     * @param \AppBundle\Entity\Bank $bank
     * @return Transfer
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
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\TransferTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\TransferTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
}
