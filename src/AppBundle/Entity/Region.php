<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 *
 * @ORM\Table(name="regions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegionRepository")
 */
class Region
{
    /**
     * @var int
     *
     * @ORM\Column(name="region_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $regionId;

    /**
     * @var int
     *
     * @ORM\Column(name="region_order", type="integer", nullable=true)
     */
    private $regionOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="region_title", type="string", length=255, nullable=true)
     */
    private $regionTitle;

    /**
     * Get regionId
     *
     * @return integer 
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * Set regionOrder
     *
     * @param integer $regionOrder
     * @return Region
     */
    public function setRegionOrder($regionOrder)
    {
        $this->regionOrder = $regionOrder;

        return $this;
    }

    /**
     * Get regionOrder
     *
     * @return integer 
     */
    public function getRegionOrder()
    {
        return $this->regionOrder;
    }

    /**
     * Set regionTitle
     *
     * @param string $regionTitle
     * @return Region
     */
    public function setRegionTitle($regionTitle)
    {
        $this->regionTitle = $regionTitle;

        return $this;
    }

    /**
     * Get regionTitle
     *
     * @return string 
     */
    public function getRegionTitle()
    {
        return $this->regionTitle;
    }
}
