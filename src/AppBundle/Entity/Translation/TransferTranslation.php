<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="transfer_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="transfer_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class TransferTranslation extends AbstractPersonalTranslation
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Transfer", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="transfer_id", onDelete="CASCADE")
     */
    protected $object;
    
}
