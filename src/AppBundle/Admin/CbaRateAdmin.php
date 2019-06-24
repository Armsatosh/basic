<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class CbaRateAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                    ->add('cbaRateCurrencyIso')
                    ->add('cbaRateRate')
                    ->add('cbaRateUpdateDate')
                    ->add('cbaRateGetDate')
                ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                    ->add('cbaRateCurrencyIso')
                    ->add('cbaRateRate')
                    ->add('cbaRateUpdateDate')
                    ->add('cbaRateGetDate')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('cbaRateCurrencyIso')
                ->add('cbaRateRate')
                ->add('cbaRateUpdateDate')
                ->add('cbaRateGetDate')
            ;
    }
    
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'cbaRateUpdateDate'
    );
    
}
