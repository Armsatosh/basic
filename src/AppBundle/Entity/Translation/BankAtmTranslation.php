<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="bank_atm_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="bank_atm_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class BankAtmTranslation extends AbstractPersonalTranslation
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BankAtm", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="bank_atm_id", onDelete="CASCADE")
     */
    protected $object;
    
}
