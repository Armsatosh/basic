<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TransferCurrency
 *
 * @ORM\Table(name="transfer_currencies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransferCurrencyRepository")
 */
class TransferCurrency
{
    /**
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="transferCurrencies")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="currency_id")
     * 
     */
    private $currency;
    
    /**
     * @ORM\ManyToOne(targetEntity="Transfer", inversedBy="transferCurrencies")
     * @ORM\JoinColumn(name="transfer_id", referencedColumnName="transfer_id")
     * 
     */
    private $transfer;
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_currency_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $transferCurrencyId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_id", type="integer", nullable=true)
     */
    private $transferId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="currency_id", type="integer", nullable=true)
     */
    private $currencyId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_currency_min", type="integer", nullable=true)
     */
    private $transferCurrencyMin;
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_currency_max", type="integer", nullable=true)
     */
    private $transferCurrencyMax;
    
    /**
     * @var int
     *
     * @ORM\Column(name="transfer_currency_io", type="integer", nullable=true)
     */
    private $transferCurrencyIo;

    /**
     * Get transferCurrencyId
     *
     * @return integer 
     */
    public function getTransferCurrencyId()
    {
        return $this->transferCurrencyId;
    }

    /**
     * Set transferCurrencyIo
     *
     * @param integer $transferCurrencyIo
     * @return TransferCurrency
     */
    public function setTransferCurrencyIo($transferCurrencyIo)
    {
        $this->transferCurrencyIo = $transferCurrencyIo;

        return $this;
    }

    /**
     * Get transferCurrencyIo
     *
     * @return integer 
     */
    public function getTransferCurrencyIo()
    {
        return $this->transferCurrencyIo;
    }

    /**
     * Set currency
     *
     * @param \AppBundle\Entity\Currency $currency
     * @return TransferCurrency
     */
    public function setCurrency(\AppBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \AppBundle\Entity\Currency 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set transfer
     *
     * @param \AppBundle\Entity\Transfer $transfer
     * @return TransferCurrency
     */
    public function setTransfer(\AppBundle\Entity\Transfer $transfer = null)
    {
        $this->transfer = $transfer;

        return $this;
    }

    /**
     * Get transfer
     *
     * @return \AppBundle\Entity\Transfer 
     */
    public function getTransfer()
    {
        return $this->transfer;
    }

    /**
     * Set transferId
     *
     * @param integer $transferId
     * @return TransferCurrency
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

    /**
     * Set currencyId
     *
     * @param integer $currencyId
     * @return TransferCurrency
     */
    public function setCurrencyId($currencyId)
    {
        $this->currencyId = $currencyId;

        return $this;
    }

    /**
     * Get currencyId
     *
     * @return integer 
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    /**
     * Set transferCurrencyMin
     *
     * @param integer $transferCurrencyMin
     * @return TransferCurrency
     */
    public function setTransferCurrencyMin($transferCurrencyMin)
    {
        $this->transferCurrencyMin = $transferCurrencyMin;

        return $this;
    }

    /**
     * Get transferCurrencyMin
     *
     * @return integer 
     */
    public function getTransferCurrencyMin()
    {
        return $this->transferCurrencyMin;
    }

    /**
     * Set transferCurrencyMax
     *
     * @param integer $transferCurrencyMax
     * @return TransferCurrency
     */
    public function setTransferCurrencyMax($transferCurrencyMax)
    {
        $this->transferCurrencyMax = $transferCurrencyMax;

        return $this;
    }

    /**
     * Get transferCurrencyMax
     *
     * @return integer 
     */
    public function getTransferCurrencyMax()
    {
        return $this->transferCurrencyMax;
    }
}
