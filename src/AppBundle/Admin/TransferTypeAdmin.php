<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class TransferTypeAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('transferTypeOrder', 'number')
                ->add('transferTypeTitle', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('transferTypeTitle')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('transferTypeOrder', 'integer', array('editable' => true))
                ->addIdentifier('transferTypeTitle');
    }
    
}
