<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use AppBundle\Form\Type\TranslatedFieldType;


class CountryAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('countryTitle', 'translatable_field', array(
                    'field'                => 'countryTitle',
                    'personal_translation' => 'AppBundle\Entity\Translation\CountryTranslation',
                    'property_path'        => 'translations',
                ))
                ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('countryTitle')
                ;
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('countryTitle');
    }
    
}
