<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class BankRateAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                    ->add('bank', 'entity', array(
                        'class' => 'AppBundle\Entity\Bank',
                        'property' => 'bankTitle'
                    ))
                    ->add('currency', 'entity', array(
                        'class' => 'AppBundle\Entity\Currency',
                        'property' => 'currencySymbol'
                    ))
                    ->add('rateBuy')
                    ->add('rateSell')
                    ->add('rateUpdateDate')
                ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                    ->add('currency.currencySymbol')
                    ->add('bank.bankTitle')
                    ->add('rateUpdateDate')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('bank.bankTitle')
                ->addIdentifier('currency.currencySymbol')
                ->add('rateBuy', null, array('editable' => true))
                ->add('rateSell', null, array('editable' => true))
                ->add('rateUpdateDate')
            ;
    }
    
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'rateUpdateDate'
    );
    
}
