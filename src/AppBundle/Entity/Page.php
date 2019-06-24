<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Page
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\PageTranslation")
 */
class Page extends AbstractPersonalTranslatable implements TranslatableInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="page_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pageId;

    /**
     * @var string
     * 
     * @ORM\Column(name="page_slug", type="string", length=255, unique=true)
     */
    private $pageSlug;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="page_title", type="string", length=255, nullable=true)
     */
    private $pageTitle;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="page_text", type="text", nullable=true)
     */
    private $pageText;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="page_meta_keywords", type="string", length=255, nullable=true)
     */
    private $pageMetaKeywords;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="page_meta_description", type="string", length=255, nullable=true)
     */
    private $pageMetaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="page_og_image", type="string", length=255, nullable=true)
     */
    private $pageOgImage;

    
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\PageTranslation",
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pageId
     *
     * @param integer $pageId
     * @return Page
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;

        return $this;
    }

    /**
     * Get pageId
     *
     * @return integer 
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * Set pageSlug
     *
     * @param string $pageSlug
     * @return Page
     */
    public function setPageSlug($pageSlug)
    {
        $this->pageSlug = $pageSlug;

        return $this;
    }

    /**
     * Get pageSlug
     *
     * @return string 
     */
    public function getPageSlug()
    {
        return $this->pageSlug;
    }

    /**
     * Set pageTitle
     *
     * @param string $pageTitle
     * @return Page
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get pageTitle
     *
     * @return string 
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set pageText
     *
     * @param string $pageText
     * @return Page
     */
    public function setPageText($pageText)
    {
        $this->pageText = $pageText;

        return $this;
    }

    /**
     * Get pageText
     *
     * @return string 
     */
    public function getPageText()
    {
        return $this->pageText;
    }

    /**
     * Set pageMetaKeywords
     *
     * @param string $pageMetaKeywords
     * @return Page
     */
    public function setPageMetaKeywords($pageMetaKeywords)
    {
        $this->pageMetaKeywords = $pageMetaKeywords;

        return $this;
    }

    /**
     * Get pageMetaKeywords
     *
     * @return string 
     */
    public function getPageMetaKeywords()
    {
        return $this->pageMetaKeywords;
    }

    /**
     * Set pageMetaDescription
     *
     * @param string $pageMetaDescription
     * @return Page
     */
    public function setPageMetaDescription($pageMetaDescription)
    {
        $this->pageMetaDescription = $pageMetaDescription;

        return $this;
    }

    /**
     * Get pageMetaDescription
     *
     * @return string 
     */
    public function getPageMetaDescription()
    {
        return $this->pageMetaDescription;
    }

    /**
     * Set pageOgImage
     *
     * @param string $pageOgImage
     * @return Page
     */
    public function setPageOgImage($pageOgImage)
    {
        $this->pageOgImage = $pageOgImage;

        return $this;
    }

    /**
     * Get pageOgImage
     *
     * @return string 
     */
    public function getPageOgImage()
    {
        return $this->pageOgImage;
    }
    
    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        
        return 'img/pages/uploads/'.$this->getPageId();
    }

    public function getAbsolutePath()
    {
        
        return null === $this->pageOgImage ? null : $this->getUploadRootDir().'/'.$this->pageOgImage;
        
    }

    public function getWebPath()
    {
        
        return null === $this->pageOgImage ? null : $this->getUploadDir().'/'.$this->pageOgImage;

    }
    
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
    

    /**
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\PageTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\PageTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
}
