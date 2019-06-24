<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="bank_branch_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="bank_branch_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class BankBranchTranslation extends AbstractPersonalTranslation
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BankBranch", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="bank_branch_id", onDelete="CASCADE")
     */
    protected $object;
    
}
