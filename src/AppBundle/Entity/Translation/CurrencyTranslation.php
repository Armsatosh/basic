<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="currency_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="currency_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class CurrencyTranslation extends AbstractPersonalTranslation
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Currency", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="currency_id", onDelete="CASCADE")
     */
    protected $object;
    
}
