<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use AppBundle\Form\Type\TranslatedFieldType;

use AppBundle\Entity\BankBranch;

class BankBranchAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $myEntity = new BankBranch();
        
        $formMapper
                ->add('bankBranchOrder', 'number')
                ->add('bankBranchTitle', 'translatable_field', array(
                    'field'                => 'bankBranchTitle',
                    'personal_translation' => 'AppBundle\Entity\Translation\BankBranchTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('bank', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Bank',
                    'property' => 'bankTitle'
                ))
                ->add('armRegion', 'entity', array(
                    'class' => 'AppBundle\Entity\ArmRegion',
                    'property' => 'armRegionTitle'
                ))
                ->add('armAdministrative', 'entity', array(
                    'class' => 'AppBundle\Entity\ArmAdministrative',
                    'property' => 'armAdministrativeTitle'
                ))
                ->add('bankBranchOpenHours', 'translatable_field', array(
                    'field'          => 'bankBranchOpenHours',
                    'property_path'  => 'translations',
                    'widget' => 'textarea',
//                    'attr' => array('class' => 'ckeditor'),
                    'personal_translation' => '\AppBundle\Entity\Translation\BankBranchTranslation',
                    'required' => false
                ))
                ->add('bankBranchAddress', 'translatable_field', array(
                    'field'          => 'bankBranchAddress',
                    'property_path'  => 'translations',
                    'widget' => 'textarea',
//                    'attr' => array('class' => 'ckeditor'),
                    'personal_translation' => '\AppBundle\Entity\Translation\BankBranchTranslation',
                    'required' => false
                ))
                ->add('bankBranchPhones', 'collection', array(
                    'entry_type' => 'text',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'required' => false
                ))
                ->add('bankBranchEmails', 'collection', array(
                    'entry_type' => 'text',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'required' => false
                ))
                ->end()
                ->with('Map Details')
                    ->add('bankBranchLat', 'text', array('required' => false))
                    ->add('bankBranchLong', 'text', array('required' => false))
                ->end()
                ->with('Branch Image')
                    ->add('bankBranchOgImage', 'comur_image', array(
                            'uploadConfig' => array(
                                'uploadRoute' => 'comur_api_upload', //optional
                                'uploadUrl' => $myEntity->getUploadRootDir(), // required - see explanation below (you can also put just a dir path)
                                'webDir' => $myEntity->getUploadDir(), // required - see explanation below (you can also put just a dir path)
                                'fileExt' => '*.jpg;*.gif;*.png;*.jpeg', //optional
                                'libraryDir' => null, //optional
                                'libraryRoute' => 'comur_api_image_library', //optional
                                'showLibrary' => true, //optional
    //                            'saveOriginal' => 'originalImage', //optional
                                'generateFilename' => true          //optional
                            ),
                            'cropConfig' => array(
                                'minWidth' => 1200,
                                'minHeight' => 630,
                                'aspectRatio' => true, //optional
                                'cropRoute' => 'comur_api_crop', //optional
                                'forceResize' => false, //optional
                                'thumbs' => array(//optional
                                    array(
                                        'maxWidth' => 1200,
                                        'maxHeight' => 630,
                                        'useAsFieldImage' => true  //optional
                                    )
                                )
                            ),
                            'required' => false
                        )
                    )
                ->end()
                ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('bank.bankTitle')
                ->add('bankBranchTitle')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('bankBranchOrder', 'integer', array('editable' => true))
                ->add('bank.bankTitle')
                ->addIdentifier('bankBranchTitle');
    }
    
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'bankBranchOrder',
    );
    
}
