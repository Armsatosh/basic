<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class TransferAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('transferOrder', 'number')
                ->add('bank', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Bank',
                    'property' => 'bankTitle'
                ))
                ->add('transferType', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\TransferType',
                    'property' => 'transferTypeTitle'
                ))
                ->add('transferComMin', 'number')
                ->add('transferComMax', 'number', array('required' => false))
                ->add('transferComPercent', 'percent', array('required' => false))
                ->add('transferSpeedMinute', 'number')
                ->add('transferCurrencies', 'sonata_type_collection', array(
                        'type_options' => array(
                            'delete' => true
                        )
                    ), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    )
                )
                ->add('transferOtherConditions', 'textarea', array('required' => false))
                ->add('transferDescription', 'textarea', array('required' => false))
                ->add('transferLink', 'text', array('required' => false))
                ->add('transferUpdateDate', 'datetime', array('required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('transferType.transferTypeTitle')
                ->add('bank.bankTitle')
                ->add('transferComMin')
                ->add('transferComMax')
                ->add('transferComPercent')
                ->add('transferSpeedMinute')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('transferOrder', 'integer', array('editable' => true))
                ->addIdentifier('bank.bankTitle')
                ->add('transferComMin')
                ->add('transferComMax')
                ->add('transferComPercent')
                ->add('transferSpeedMinute')
                ->add('transferType.transferTypeTitle');
    }
    
}
