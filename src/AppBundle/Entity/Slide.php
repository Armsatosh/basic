<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Slide
 * @ORM\Table(name="slides")
 * @ORM\Entity
 */
class Slide
{
    /**
     * @var int
     *
     * @ORM\Column(name="slide_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $slideId;

    /**
     * @var int
     *
     * @ORM\Column(name="slide_order", type="integer", nullable=true)
     */
    private $slideOrder;
    
    /**
     * @var string
     *
     * @ORM\Column(name="slide_image", type="string", length=255, nullable=true)
     */
    private $slideImage;
    
    
    

    /**
     * Get slideId
     *
     * @return integer 
     */
    public function getSlideId()
    {
        return $this->slideId;
    }

    /**
     * Set slideOrder
     *
     * @param integer $slideOrder
     * @return Slide
     */
    public function setSlideOrder($slideOrder)
    {
        $this->slideOrder = $slideOrder;

        return $this;
    }

    /**
     * Get slideOrder
     *
     * @return integer 
     */
    public function getSlideOrder()
    {
        return $this->slideOrder;
    }

    /**
     * Set slideImage
     *
     * @param string $slideImage
     * @return Slide
     */
    public function setSlideImage($slideImage)
    {
        $this->slideImage = $slideImage;

        return $this;
    }

    /**
     * Get slideImage
     *
     * @return string 
     */
    public function getSlideImage()
    {
        return $this->slideImage;
    }
    
    /**
     * Get slideImage
     *
     * @return string 
     */
    public function getPageOgImage()
    {
        return $this->slideImage;
    }
    
    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        
        return 'img/slides/uploads/';
    }

    public function getAbsolutePath()
    {
        
        return null === $this->slideImage ? null : $this->getUploadRootDir().'/'.$this->slideImage;
        
    }

    public function getWebPath()
    {
        
        return null === $this->slideImage ? null : $this->getUploadDir().'/'.$this->slideImage;

    }
    
}
