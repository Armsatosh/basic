<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="countries_transfers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CountryTransferRepository")
 */
class CountryTransfer
{
    /**
     * @var int
     *
     * @ORM\Column(name="country_transfer_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $countryTransferId;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="country_id", type="integer", nullable=true)
     */
    private $countryId;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="transfer_id", type="integer", nullable=true)
     */
    private $transferId;
    

    /**
     * Get countryTransferId
     *
     * @return integer 
     */
    public function getCountryTransferId()
    {
        return $this->countryTransferId;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     * @return CountryTransfer
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set transferId
     *
     * @param integer $transferId
     * @return CountryTransfer
     */
    public function setTransferId($transferId)
    {
        $this->transferId = $transferId;

        return $this;
    }

    /**
     * Get transferId
     *
     * @return integer 
     */
    public function getTransferId()
    {
        return $this->transferId;
    }
}
