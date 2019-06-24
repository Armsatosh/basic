<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use AppBundle\Form\Type\TranslatedFieldType;


class BankAtmAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('bankAtmOrder', 'number')
                ->add('bank', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Bank',
                    'property' => 'bankTitle'
                ))
                ->add('armRegion', 'entity', array(
                    'class' => 'AppBundle\Entity\ArmRegion',
                    'property' => 'armRegionTitle'
                ))
                ->add('armAdministrative', 'entity', array(
                    'class' => 'AppBundle\Entity\ArmAdministrative',
                    'property' => 'armAdministrativeTitle'
                ))
                ->add('bankAtmAddress', 'translatable_field', array(
                    'field'          => 'bankAtmAddress',
                    'property_path'  => 'translations',
                    'widget' => 'textarea',
//                    'attr' => array('class' => 'ckeditor'),
                    'personal_translation' => '\AppBundle\Entity\Translation\BankAtmTranslation',
                    'required' => false
                ))
                ->add('bankAtmDescription', 'translatable_field', array(
                    'field'          => 'bankAtmDescription',
                    'property_path'  => 'translations',
                    'widget' => 'textarea',
//                    'attr' => array('class' => 'ckeditor'),
                    'personal_translation' => '\AppBundle\Entity\Translation\BankAtmTranslation',
                    'required' => false
                ))
                ->end()
                ->with('Map Details')
                    ->add('bankAtmLat', 'text', array('required' => false))
                    ->add('bankAtmLong', 'text', array('required' => false))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('bank.bankTitle')
                ->add('bankAtmAddress')
                ->add('bankAtmDescription')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
//        $listMapper->addIdentifier('bankBranchTitle');
        $listMapper
                ->add('bankAtmOrder', 'integer', array('editable' => true))
                ->add('bank.bankTitle')
                ->addIdentifier('bankAtmAddress')
                ->add('bankAtmDescription');
    }

    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'bankAtmOrder',
    );

}
