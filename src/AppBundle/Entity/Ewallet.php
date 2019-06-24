<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ewallet
 *
 * @ORM\Table(name="ewallets")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EwalletRepository")
 */
class Ewallet
{
    
    /**
     * @ORM\OneToMany(targetEntity="EwalletRate", mappedBy="ewallet")
     */
    private $ewalletRates;
    
    public function __construct()
    {
        $this->ewalletRates = new ArrayCollection();
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="ewallet_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ewalletId;

    /**
     * @var string
     *
     * @ORM\Column(name="ewallet_title", type="string", length=255, nullable=true)
     */
    private $ewalletTitle;


    /**
     * Get id
     *
     * @return integer 
     */
    public function setEwalletId($ewalletId)
    {
        $this->ewalletId = $ewalletId;

        return $this;
    }

    /**
     * Get ewalletId
     *
     * @return integer 
     */
    public function getEwalletId()
    {
        return $this->ewalletId;
    }

    /**
     * Set ewalletTitle
     *
     * @param string $ewalletTitle
     * @return Ewallet
     */
    public function setEwalletTitle($ewalletTitle)
    {
        $this->ewalletTitle = $ewalletTitle;

        return $this;
    }

    /**
     * Get ewalletTitle
     *
     * @return string 
     */
    public function getEwalletTitle()
    {
        return $this->ewalletTitle;
    }

    /**
     * Add ewalletRates
     *
     * @param \AppBundle\Entity\EwalletRate $ewalletRates
     * @return Ewallet
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
}
