<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="country_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="country_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class CountryTranslation extends AbstractPersonalTranslation
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="country_id", onDelete="CASCADE")
     */
    protected $object;
    
}
