<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ArmAdministrative
 *
 * @ORM\Table(name="arm_administratives")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArmAdministrativeRepository")
 */
class ArmAdministrative
{
    /**
     * @ORM\ManyToOne(targetEntity="ArmRegion", inversedBy="armAdministratives")
     * @ORM\JoinColumn(name="arm_region_id", referencedColumnName="arm_region_id")
     */
    private $armRegion;
    
    /**
     * @ORM\OneToMany(targetEntity="BankBranch", mappedBy="armAdministrative")
     */
    private $bankBranches;
    
    /**
     * @ORM\OneToMany(targetEntity="BankAtm", mappedBy="armAdministrative")
     */
    private $bankAtms;
    
    /**
     * @ORM\OneToMany(targetEntity="CreditCompanyBranch", mappedBy="armAdministrative")
     */
    private $creditCompanyBranches;
    
    public function __construct()
    {
        $this->bankBranches = new ArrayCollection();
        $this->bankAtms = new ArrayCollection();
        $this->creditCompanyBranches = new ArrayCollection();
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="arm_administrative_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $armAdministrativeId;

    /**
     * @var int
     *
     * @ORM\Column(name="arm_administrative_order", type="integer")
     */
    private $armAdministrativeOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="arm_administrative_title", type="string", length=255)
     */
    private $armAdministrativeTitle;

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
     * Set armAdministrativeOrder
     *
     * @param integer $armAdministrativeOrder
     * @return ArmAdministrative
     */
    public function setArmAdministrativeOrder($armAdministrativeOrder)
    {
        $this->armAdministrativeOrder = $armAdministrativeOrder;

        return $this;
    }

    /**
     * Get armAdministrativeOrder
     *
     * @return integer 
     */
    public function getArmAdministrativeOrder()
    {
        return $this->armAdministrativeOrder;
    }

    /**
     * Set armAdministrativeTitle
     *
     * @param string $armAdministrativeTitle
     * @return ArmAdministrative
     */
    public function setArmAdministrativeTitle($armAdministrativeTitle)
    {
        $this->armAdministrativeTitle = $armAdministrativeTitle;

        return $this;
    }

    /**
     * Get armAdministrativeTitle
     *
     * @return string 
     */
    public function getArmAdministrativeTitle()
    {
        return $this->armAdministrativeTitle;
    }

    /**
     * Set armRegion
     *
     * @param \AppBundle\Entity\ArmRegion $armRegion
     * @return ArmAdministrative
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
     * Add bankBranches
     *
     * @param \AppBundle\Entity\BankBranch $bankBranches
     * @return ArmAdministrative
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
     * @return ArmAdministrative
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
     * Add creditCompanyBranches
     *
     * @param \AppBundle\Entity\CreditCompanyBranch $creditCompanyBranches
     * @return ArmAdministrative
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
