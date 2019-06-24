<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class CurrencyAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('currencySymbol', 'text')
                ->add('currencyTitle', 'translatable_field', array(
                    'field'                => 'currencyTitle',
                    'personal_translation' => 'AppBundle\Entity\Translation\CurrencyTranslation',
                    'property_path'        => 'translations',
                ))
                ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('currencySymbol')
                ->add('currencyTitle')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('currencyOrder', 'integer', array('editable' => true))
            ->addIdentifier('currencySymbol')
            ->add('currencyTitle');
    }
    
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'currencyOrder'
    );
    
}
