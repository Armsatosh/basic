<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class DepositDayAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('depositDayTitle', 'text')
                ->add('depositDayMin', 'number')
                ->add('depositDayMax', 'number')
                ->add('depositDayMonth', 'number')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('depositDayTitle', 'text', array('editable' => true))
                ->add('depositDayMin', 'integer', array('editable' => true))
                ->add('depositDayMax', 'integer', array('editable' => true))
                ->add('depositDayMonth', 'integer', array('editable' => true))
                ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('depositDayTitle')
                ->add('depositDayMin')
                ->add('depositDayMax')
                ->add('depositDayMonth')
                ;
    }
    
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'depositDayMin'
    );
    
}
