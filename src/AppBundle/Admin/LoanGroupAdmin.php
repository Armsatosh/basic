<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class LoanGroupAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('loanGroupOrder', 'number')
                ->add('loanGroupTitle', 'translatable_field', array(
                    'field'                => 'loanGroupTitle',
                    'personal_translation' => 'AppBundle\Entity\Translation\LoanGroupTranslation',
                    'property_path'        => 'translations',
                ))
                ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('loanGroupTitle');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('loanGroupOrder', 'integer', array('editable' => true))
                ->addIdentifier('loanGroupTitle');
    }

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'loanGroupOrder',
    ];
    
}
