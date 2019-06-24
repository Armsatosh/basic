<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ArmRegion
 *
 * @ORM\Table(name="arm_regions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArmRegionRepository")
 */
class ArmRegion
{
    /**
     * @ORM\OneToMany(targetEntity="ArmAdministrative", mappedBy="armRegion")
     */
    private $armAdministratives;
    
    /**
     * @ORM\OneToMany(targetEntity="BankBranch", mappedBy="armRegion")
     */
    private $bankBranches;
    
    /**
     * @ORM\OneToMany(targetEntity="BankAtm", mappedBy="armRegion")
     */
    private $bankAtm;
    
    /**
     * @ORM\OneToMany(targetEntity="CreditCompanyBranch", mappedBy="armRegion")
     */
    private $creditCompanyBranches;
    
    public function __construct()
    {
        $this->armAdministratives = new ArrayCollection();
        $this->bankBranches = new ArrayCollection();
        $this->bankAtm = new ArrayCollection();
        $this->creditCompanyBranches = new ArrayCollection();
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="arm_region_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $armRegionId;

    /**
     * @var int
     *
     * @ORM\Column(name="arm_region_order", type="integer")
     */
    private $armRegionOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="arm_region_title", type="string", length=255, nullable=true)
     */
    private $armRegionTitle;

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
     * Set armRegionOrder
     *
     * @param integer $armRegionOrder
     * @return ArmRegion
     */
    public function setArmRegionOrder($armRegionOrder)
    {
        $this->armRegionOrder = $armRegionOrder;

        return $this;
    }

    /**
     * Get armRegionOrder
     *
     * @return integer 
     */
    public function getArmRegionOrder()
    {
        return $this->armRegionOrder;
    }

    /**
     * Set armRegionTitle
     *
     * @param string $armRegionTitle
     * @return ArmRegion
     */
    public function setArmRegionTitle($armRegionTitle)
    {
        $this->armRegionTitle = $armRegionTitle;

        return $this;
    }

    /**
     * Get armRegionTitle
     *
     * @return string 
     */
    public function getArmRegionTitle()
    {
        return $this->armRegionTitle;
    }

    /**
     * Add armAdministratives
     *
     * @param \AppBundle\Entity\ArmAdministrative $armAdministratives
     * @return ArmRegion
     */
    public function addArmAdministrative(\AppBundle\Entity\ArmAdministrative $armAdministratives)
    {
        $this->armAdministratives[] = $armAdministratives;

        return $this;
    }

    /**
     * Remove armAdministratives
     *
     * @param \AppBundle\Entity\ArmAdministrative $armAdministratives
     */
    public function removeArmAdministrative(\AppBundle\Entity\ArmAdministrative $armAdministratives)
    {
        $this->armAdministratives->removeElement($armAdministratives);
    }

    /**
     * Get armAdministratives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArmAdministratives()
    {
        return $this->armAdministratives;
    }

    /**
     * Add bankBranches
     *
     * @param \AppBundle\Entity\ArmAdministrative $bankBranches
     * @return ArmRegion
     */
    public function addBankBranch(\AppBundle\Entity\ArmAdministrative $bankBranches)
    {
        $this->bankBranches[] = $bankBranches;

        return $this;
    }

    /**
     * Remove bankBranches
     *
     * @param \AppBundle\Entity\ArmAdministrative $bankBranches
     */
    public function removeBankBranch(\AppBundle\Entity\ArmAdministrative $bankBranches)
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
     * Add bankAtm
     *
     * @param \AppBundle\Entity\ArmAdministrative $bankAtm
     * @return ArmRegion
     */
    public function addBankAtm(\AppBundle\Entity\ArmAdministrative $bankAtm)
    {
        $this->bankAtm[] = $bankAtm;

        return $this;
    }

    /**
     * Remove bankAtm
     *
     * @param \AppBundle\Entity\ArmAdministrative $bankAtm
     */
    public function removeBankAtm(\AppBundle\Entity\ArmAdministrative $bankAtm)
    {
        $this->bankAtm->removeElement($bankAtm);
    }

    /**
     * Get bankAtm
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBankAtm()
    {
        return $this->bankAtm;
    }

    /**
     * Add creditCompanyBranches
     *
     * @param \AppBundle\Entity\CreditCompanyBranch $creditCompanyBranches
     * @return ArmRegion
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
}
