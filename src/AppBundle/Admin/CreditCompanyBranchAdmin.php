<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use AppBundle\Entity\CreditCompanyBranch;

class CreditCompanyBranchAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $myEntity = new CreditCompanyBranch();
        
        $formMapper
                ->add('creditCompanyBranchOrder', 'number')
                ->add('creditCompanyBranchTitle', 'translatable_field', array(
                    'field'                => 'creditCompanyBranchTitle',
                    'personal_translation' => 'AppBundle\Entity\Translation\CreditCompanyBranchTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('creditCompany', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\CreditCompany',
                    'property' => 'creditCompanyTitle'
                ))
                ->add('armRegion', 'entity', array(
                    'class' => 'AppBundle\Entity\ArmRegion',
                    'property' => 'armRegionTitle'
                ))
                ->add('armAdministrative', 'entity', array(
                    'class' => 'AppBundle\Entity\ArmAdministrative',
                    'property' => 'armAdministrativeTitle'
                ))
                ->add('creditCompanyBranchOpenHours', 'translatable_field', array(
                    'field'          => 'creditCompanyBranchOpenHours',
                    'personal_translation' => '\AppBundle\Entity\Translation\CreditCompanyBranchTranslation',
                    'property_path'  => 'translations',
                    'widget' => 'textarea',
//                    'attr' => array('class' => 'ckeditor')
                ))
                ->add('creditCompanyBranchAddress', 'translatable_field', array(
                    'field'          => 'creditCompanyBranchAddress',
                    'personal_translation' => '\AppBundle\Entity\Translation\CreditCompanyBranchTranslation',
                    'property_path'  => 'translations',
                    'widget' => 'textarea',
//                    'attr' => array('class' => 'ckeditor')
                ))
                ->add('creditCompanyBranchPhones', 'collection', array(
                    'entry_type' => 'text',
                    'allow_add' => true,
                    'allow_delete' => true,
                ))
                ->add('creditCompanyBranchEmails', 'collection', array(
                    'entry_type' => 'text',
                    'allow_add' => true,
                    'allow_delete' => true,
                ))
                ->end()
                ->with('Map Details')
                    ->add('creditCompanyBranchLat', 'text', array('required' => false))
                    ->add('creditCompanyBranchLong', 'text', array('required' => false))
                ->end()
                ->with('Branch Image')
                    ->add('creditCompanyBranchOgImage', 'comur_image', array(
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
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('creditCompanyBranchTitle')
                ->add('creditCompany.creditCompanyTitle')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('creditCompanyBranchOrder', 'integer', array('editable' => true))
                ->add('creditCompany.creditCompanyTitle')
                ->addIdentifier('creditCompanyBranchTitle');
    }
    
}
