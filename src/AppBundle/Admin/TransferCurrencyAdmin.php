<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class TransferCurrencyAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('currency', 'entity', array(
            'class' => 'AppBundle\Entity\Currency',
            'property' => 'currencySymbol'
        ))
        ->add('transferCurrencyIo', 'choice', array(
            'choices' => array(
                0 => 'Ուղարկել',
                1 => 'Ստանալ'
            )
        ))
        ->add('transferCurrencyMin', 'number')
        ->add('transferCurrencyMax', 'number');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('transferCurrencyMin')
                ->add('transferCurrencyMax')
                ->add('transfer.bank.bankTitle')
                ->add('transfer.transferType.transferTypeTitle')
                ->add('transfer.transferComMin')
                ->add('transfer.transferComMax')
                ->add('transfer.transferComPercent')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('currency.currencySymbol')
                ->add('transfer.bank.bankTitle')
                ->add('transfer.transferType.transferTypeTitle')
                ->add('transfer.transferComMin')
                ->add('transfer.transferComMax')
                ->add('transfer.transferComPercent')
                ->addIdentifier('transferCurrencyMin')
                ->add('transferCurrencyMax');
    }
    
}
