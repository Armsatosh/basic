<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="credit_company_branch_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="credit_company_branch_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class CreditCompanyBranchTranslation extends AbstractPersonalTranslation
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CreditCompanyBranch", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="credit_company_branch_id", onDelete="CASCADE")
     */
    protected $object;
    
}
