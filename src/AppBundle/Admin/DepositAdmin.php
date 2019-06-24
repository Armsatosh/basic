<?php

namespace AppBundle\Admin;

use Doctrine\DBAL\Types\IntegerType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class DepositAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('depositTitle', 'text')
                ->add('depositOrder')
                ->add('bank', null, array(
                    'class' => 'AppBundle\Entity\Bank',
                    'property' => 'bankTitle'
                ))
                ->add('currency', null, array(
                    'class' => 'AppBundle\Entity\Currency',
                    'property' => 'currencySymbol'
                ))
                ->add('depositCustomerType', 'choice', array(
                    'choices' => array(
                        0 => 'Ֆիզիկական անձ',
                        1 => 'Իրավաբանական անձ'
                    )
                ))
                ->add('depositMin', 'number', array('required' => false))
                ->add('depositMax', 'number', array('required' => false))

                ->add('depositDepositDays', 'sonata_type_collection',
                        array(
                            'by_reference' => true,
                            'required' => false,
                            'type_options' => array(
                                'delete' => true
                            )
                        ),
                        array(
                            'edit' => 'inline',
                            'inline' => 'table'
//                        ,
//                            'target_entity' => 'AppBundle\Entity\DepositsDepositDays'
                        )
                    )
                
//                ->add('depositDepositDays', 'sonata_type_collection', array(
//                        'by_reference' => false,
//                        'type_options' => array(
//                            'delete' => true
//                        )
//                    ), array(
//                        'edit' => 'inline',
//                        'inline' => 'table',
//                        'sortable' => 'position',
//                    )
//                )
                
                ->add('depositDescription', 'textarea', array('required' => false))
                ->add('depositLink', 'text', array('required' => false))
                ->add('depositUpdateDate', 'datetime', array('required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('depositTitle')
                ->add('bank.bankTitle')
                ->add('depositMin')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('bank.bankTitle')
                ->add('depositOrder', 'integer', array('editable' => true))
                ->addIdentifier('depositTitle')
                ->add('currency.currencySymbol')
                ->add('depositMin');
    }


    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'depositOrder',
    ];
}
