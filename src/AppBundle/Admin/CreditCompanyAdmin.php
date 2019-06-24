<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use AppBundle\Form\Type\TranslatedFieldType;

use AppBundle\Entity\CreditCompany;

class CreditCompanyAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $myEntity = new CreditCompany();
        
        $formMapper
                ->add('creditCompanyOrder', 'number')
                ->add('creditCompanyTitle', 'translatable_field', array(
                    'field'                => 'creditCompanyTitle',
                    'personal_translation' => 'AppBundle\Entity\Translation\CreditCompanyTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('creditCompanyTinNumber', 'text', array('required' => false))
                ->add('creditCompanyLink', 'text', array('required' => false))
                ->add('creditCompanyMetaKeywords', 'translatable_field', array(
                    'field'                => 'creditCompanyMetaKeywords',
                    'personal_translation' => 'AppBundle\Entity\Translation\CreditCompanyTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('creditCompanyMetaDescription', 'translatable_field', array(
                    'field'                => 'creditCompanyMetaDescription',
                    'personal_translation' => 'AppBundle\Entity\Translation\CreditCompanyTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('creditCompanyMapMarker', 'comur_image', array(
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
                            'minWidth' => 32,
                            'minHeight' => 32,
                            'aspectRatio' => true, //optional
                            'cropRoute' => 'comur_api_crop', //optional
                            'forceResize' => false, //optional
                            'thumbs' => array(//optional
                                array(
                                    'maxWidth' => 32,
                                    'maxHeight' => 32,
                                    'useAsFieldImage' => true  //optional
                                )
                            )
                        ),
                        'required' => false
                    )
                )
                ->add('creditCompanyOgImage', 'comur_image', array(
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
                ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('creditCompanyTitle')
                ->add('creditCompanyTinNumber')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('creditCompanyOrder', 'integer', array('editable' => true))
                ->addIdentifier('creditCompanyTitle')
                ->add('creditCompanyTinNumber');
    }
    
}
