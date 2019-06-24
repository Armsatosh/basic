<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="news")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\NewsTranslation")
 */
class News extends AbstractPersonalTranslatable implements TranslatableInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Gedmo\Slug(fields={"newsTitle"}, updatable=false)
     */
    private $newsSlug;

    /**
     * @ORM\Column(type="string")
     * @Gedmo\Translatable
     */
    private $newsTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $newsText;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $newsDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $newsGallery;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $newsOgImage;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $newsMetaKeywords;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Translatable
     */
    private $newsMetaDescription;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\NewsTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    protected $locale;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getNewsSlug()
    {
        return $this->newsSlug;
    }

    /**
     * @param mixed $newsSlug
     */
    public function setNewsSlug($newsSlug)
    {
        $this->newsSlug = $newsSlug;
    }

    /**
     * @return mixed
     */
    public function getNewsTitle()
    {
        return $this->newsTitle;
    }

    /**
     * @param mixed $newsTitle
     */
    public function setNewsTitle($newsTitle)
    {
        $this->newsTitle = $newsTitle;
    }

    /**
     * @return mixed
     */
    public function getNewsText()
    {
        return $this->newsText;
    }

    /**
     * @param mixed $newsText
     */
    public function setNewsText($newsText)
    {
        $this->newsText = $newsText;
    }

    /**
     * @return mixed
     */
    public function getNewsDate()
    {
        return $this->newsDate;
    }

    /**
     * @param mixed $newsDate
     */
    public function setNewsDate($newsDate)
    {
        $this->newsDate = $newsDate;
    }

    /**
     * @return mixed
     */
    public function getNewsGallery()
    {
        return $this->newsGallery;
    }

    /**
     * @param mixed $newsGallery
     */
    public function setNewsGallery($newsGallery)
    {
        $this->newsGallery = $newsGallery;
    }

    /**
     * @return mixed
     */
    public function getNewsOgImage()
    {
        return $this->newsOgImage;
    }

    /**
     * @param mixed $newsOgImage
     */
    public function setNewsOgImage($newsOgImage)
    {
        $this->newsOgImage = $newsOgImage;
    }

    /**
     * @return mixed
     */
    public function getNewsMetaKeywords()
    {
        return $this->newsMetaKeywords;
    }

    /**
     * @param mixed $newsMetaKeywords
     */
    public function setNewsMetaKeywords($newsMetaKeywords)
    {
        $this->newsMetaKeywords = $newsMetaKeywords;
    }

    /**
     * @return mixed
     */
    public function getNewsMetaDescription()
    {
        return $this->newsMetaDescription;
    }

    /**
     * @param mixed $newsMetaDescription
     */
    public function setNewsMetaDescription($newsMetaDescription)
    {
        $this->newsMetaDescription = $newsMetaDescription;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

}