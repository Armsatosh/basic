<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="bank_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="bank_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class BankTranslation extends AbstractPersonalTranslation
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bank", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="bank_id", onDelete="CASCADE")
     */
    protected $object;
    
}
