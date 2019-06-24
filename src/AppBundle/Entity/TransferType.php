<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TransferType
 *
 * @ORM\Table(name="transfer_types")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransferTypeRepository")
 */
class TransferType
{
    
    /**
     * @ORM\OneToMany(targetEntity="Transfer", mappedBy="transferType")
     */
    private $transfers;
    
    public function __construct()
    {
        $this->transfers = new ArrayCollection();
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_type_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $transferTypeId;

    /**
     * @var int
     *
     * @ORM\Column(name="transfer_type_order", type="integer", nullable=true)
     */
    private $transferTypeOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="transfer_type_title", type="string", length=255, nullable=true)
     */
    private $transferTypeTitle;

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
     * Set transferTypeOrder
     *
     * @param integer $transferTypeOrder
     * @return TransferType
     */
    public function setTransferTypeOrder($transferTypeOrder)
    {
        $this->transferTypeOrder = $transferTypeOrder;

        return $this;
    }

    /**
     * Get transferTypeOrder
     *
     * @return integer 
     */
    public function getTransferTypeOrder()
    {
        return $this->transferTypeOrder;
    }

    /**
     * Set transferTypeTitle
     *
     * @param string $transferTypeTitle
     * @return TransferType
     */
    public function setTransferTypeTitle($transferTypeTitle)
    {
        $this->transferTypeTitle = $transferTypeTitle;

        return $this;
    }

    /**
     * Get transferTypeTitle
     *
     * @return string 
     */
    public function getTransferTypeTitle()
    {
        return $this->transferTypeTitle;
    }

    /**
     * Add transfers
     *
     * @param \AppBundle\Entity\Transfer $transfers
     * @return TransferType
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
}
