<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="loan_group_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="loan_group_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class LoanGroupTranslation extends AbstractPersonalTranslation
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LoanGroup", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="loan_group_id", onDelete="CASCADE")
     */
    protected $object;
    
}
