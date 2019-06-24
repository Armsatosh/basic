<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class LoanAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->with('General Information')
                    ->add('loanOrder', 'number')
                    ->add('loanTitle', 'text')
                    ->add('loanCustomerType', 'choice', array(
                        'choices' => array(
                            0 => 'Ֆիզիկական անձ',
                            1 => 'Իրավաբանական անձ',
                            2 => 'Ֆերմեր'
                        )
                    ))
                    ->add('bank', 'sonata_type_model', array(
                        'class' => 'AppBundle\Entity\Bank',
                        'property' => 'bankTitle'
                    ))
                    ->add('loanGroup', 'sonata_type_model', array(
                        'class' => 'AppBundle\Entity\LoanGroup',
                        'property' => 'loanGroupTitle'
                    ))
                    ->add('currency', 'sonata_type_model', array(
                        'class' => 'AppBundle\Entity\Currency',
                        'property' => 'currencySymbol'
                    ))
                ->end()
                ->with('Loan Money', array('class' => 'col-md-3'))
                    ->add('loanMin', 'number', array('required' => false))
                    ->add('currencyMin', null, array(
                        'class' => 'AppBundle\Entity\Currency',
                        'property' => 'currencySymbol',
                        'required' => false
                    ))
                    ->add('loanMax', 'number', array('required' => false))
                    ->add('currencyMax', null, array(
                        'class' => 'AppBundle\Entity\Currency',
                        'property' => 'currencySymbol',
                        'required' => false
                    ))
                    ->add('loanEquivalentAmd', 'choice', array(
                            'choices' => array(
                                0 => 'No',
                                1 => 'Yes'
                            ),
                            'required' => false
                        )
                    )
                ->end()
                ->with('Loan Terms', array('class' => 'col-md-3'))
                    ->add('loanTermsMin', 'number', array('required' => false))
                    ->add('loanTermsMax', 'number', array('required' => false))
                ->end()
                ->with('Loan Deposit', array('class' => 'col-md-3'))
                    ->add('loanDepositPercentMin', 'number', array('required' => false))
                    ->add('loanDepositPercentMax', 'number', array('required' => false))
                ->end()
                ->with('Loan Percents', array('class' => 'col-md-3'))
                    ->add('loanPercentMin', 'number', array('required' => false))
                    ->add('loanPercentMax', 'number', array('required' => false))
                    ->add('loanPercentSubsidized', 'number', array('required' => false))
                ->end()
                ->with('Extra information')
                    ->add('loanLink', 'text', array('required' => false))
                    ->add('loanDescription', 'textarea', array('required' => false))
                    ->add('loanUpdateDate', 'date', array('required' => false))
                ->end()
                ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('loanTitle')
                ->add('loanGroup.loanGroupTitle')
                ->add('bank.bankTitle')
//                ->add('currency.currency_symbol')
                ->add('loanMin')
                ->add('loanMax')
                ->add('loanPercentMin')
                ->add('loanPercentMax')
                ->add('loanPercentSubsidized')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('loanOrder', 'integer', array('editable' => true))
                ->add('bank.bankTitle')
                ->add('loanGroup.loanGroupTitle')
                ->addIdentifier('loanTitle')
                ->add('currency.currency_symbol')
                ->add('loanMin')
                ->add('loanMax')
                ->add('loanPercentMin')
                ->add('loanPercentMax')
                ->add('loanPercentSubsidized')
                ;
    }

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'loanOrder',
    ];

}
