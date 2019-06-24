<?php

namespace AppBundle\Entity;

use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * LoanGroup
 *
 * @ORM\Table(name="loan_groups")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoanGroupRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\LoanGroupTranslation")
 */
class LoanGroup extends AbstractPersonalTranslatable implements TranslatableInterface
{
    /**
     * @ORM\OneToMany(targetEntity="Loan", mappedBy="loanGroup")
     */
    private $loans;
    
    /**
     * @var int
     *
     * @ORM\Column(name="loan_group_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $loanGroupId;

    /**
     * @var int
     *
     * @ORM\Column(name="loan_group_order", type="integer", nullable=true)
     */
    private $loanGroupOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="loan_group_title", type="string", length=255, nullable=true)
     */
    private $loanGroupTitle;
    
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
     *     targetEntity="AppBundle\Entity\Translation\LoanGroupTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;
    
    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->loans = new ArrayCollection();
    }
    
    /**
     * Get loanGroupId
     *
     * @return integer 
     */
    public function getLoanGroupId()
    {
        return $this->loanGroupId;
    }

    /**
     * Set loanGroupOrder
     *
     * @param integer $loanGroupOrder
     * @return LoanGroup
     */
    public function setLoanGroupOrder($loanGroupOrder)
    {
        $this->loanGroupOrder = $loanGroupOrder;

        return $this;
    }

    /**
     * Get loanGroupOrder
     *
     * @return integer 
     */
    public function getLoanGroupOrder()
    {
        return $this->loanGroupOrder;
    }

    /**
     * Set loanGroupTitle
     *
     * @param string $loanGroupTitle
     * @return LoanGroup
     */
    public function setLoanGroupTitle($loanGroupTitle)
    {
        $this->loanGroupTitle = $loanGroupTitle;

        return $this;
    }

    /**
     * Get loanGroupTitle
     *
     * @return string 
     */
    public function getLoanGroupTitle()
    {
        return $this->loanGroupTitle;
    }

    /**
     * Add loans
     *
     * @param \AppBundle\Entity\Loan $loans
     * @return LoanGroup
     */
    public function addLoan(\AppBundle\Entity\Loan $loans)
    {
        $this->loans[] = $loans;

        return $this;
    }

    /**
     * Remove loans
     *
     * @param \AppBundle\Entity\Loan $loans
     */
    public function removeLoan(\AppBundle\Entity\Loan $loans)
    {
        $this->loans->removeElement($loans);
    }

    /**
     * Get loans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLoans()
    {
        return $this->loans;
    }

    /**
     * Remove translations
     *
     * @param \AppBundle\Entity\Translation\LoanGroupTranslation $translations
     */
    public function removeTranslation(\AppBundle\Entity\Translation\LoanGroupTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }
}
