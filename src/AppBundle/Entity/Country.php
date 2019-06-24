<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Country
 *
 * @ORM\Table(name="countries")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CountryRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CountryTranslation")
 */
class Country extends AbstractPersonalTranslatable implements TranslatableInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="country_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $countryId;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="country_title", type="string", length=255, nullable=true)
     */
    private $countryTitle;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    protected $locale;
    
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\CountryTranslation",
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
     * Get countryId
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set countryTitle
     *
     * @param string $countryTitle
     * @return Country
     */
    public function setCountryTitle($countryTitle)
    {
        $this->countryTitle = $countryTitle;

        return $this;
    }

    /**
     * Get countryTitle
     *
     * @return string 
     */
    public function getCountryTitle()
    {
        return $this->countryTitle;
    }

    /**
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\CountryTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\CountryTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
}
