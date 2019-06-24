<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class EwalletRateAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('bank', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Bank',
                    'property' => 'bankTitle'
                ))
                ->add('ewallet', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Ewallet',
                    'property' => 'ewalletTitle'
                ))
                ->add('ewalletRateRefill', 'percent', array('required' => false))
                ->add('ewalletRateWithdraw', 'percent', array('required' => false))
                ->add('ewalletRateUpdateDate', 'datetime', array('required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('ewallet.ewalletTitle')
                ->add('bank.bankTitle')
                ->add('ewalletRateRefill')
                ->add('ewalletRateWithdraw')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('bank.bankTitle')
                ->addIdentifier('ewallet.ewalletTitle')
                ->add('ewalletRateRefill')
                ->add('ewalletRateWithdraw');
    }
    
}
