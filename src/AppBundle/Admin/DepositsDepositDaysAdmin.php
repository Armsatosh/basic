<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class DepositsDepositDaysAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('deposit', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Deposit',
                    'property' => 'depositTitle'
                ))
                ->add('depositDay', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\DepositDay',
                    'property' => 'depositDayTitle'
                ))
                ->add('depositDepositDayPercent', 'number')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('deposit.depositTitle')
                ->add('depositDay.depositDayTitle')
                ->add('depositDepositDayPercent')
                ;
    }
    
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'depositDay.depositDayMin'
    );
    
}
