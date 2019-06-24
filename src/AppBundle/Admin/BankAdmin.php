<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use AppBundle\Form\Type\TranslatedFieldType;

use AppBundle\Entity\Bank;

class BankAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $myEntity = new Bank();
        
        $formMapper
                ->add('bankOrder')
                ->add('bankTitle', 'translatable_field', array(
                    'field'                => 'bankTitle',
                    'personal_translation' => 'AppBundle\Entity\Translation\BankTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('bankTinNumber', 'text', array('required' => false))
                ->add('bankSwiftCode', 'text', array('required' => false))
                ->add('bankLink', 'text', array('required' => false))
                ->add('bankLinkBranches', 'text', array('required' => false))
                ->add('bankLinkAtms', 'text', array('required' => false))
                ->add('bankRateLink', 'text', array('label' => 'Bank Rate Link (Do Not Change!)', 'required' => false))
                ->add('bankMetaKeywords', 'translatable_field', array(
                    'field'                => 'bankMetaKeywords',
                    'personal_translation' => 'AppBundle\Entity\Translation\BankTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('bankMetaDescription', 'translatable_field', array(
                    'field'                => 'bankMetaDescription',
                    'personal_translation' => 'AppBundle\Entity\Translation\BankTranslation',
                    'property_path'        => 'translations',
                ))
                
                ->add('bankMapMarker', 'comur_image', array(
                        'uploadConfig' => array(
                            'uploadRoute' => 'comur_api_upload', //optional
                            'uploadUrl' => $myEntity->getUploadRootDir(), // required - see explanation below (you can also put just a dir path)
                            'webDir' => $myEntity->getUploadDir(), // required - see explanation below (you can also put just a dir path)
                            'fileExt' => '*.gif;*.png;', //optional
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
                ->add('bankOgImage', 'comur_image', array(
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
//                ->add('bankLogo', 'file', array('required' => false))
//                ->add('bankOgImage', 'file', array('required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('bankTitle')
                ->add('bankTinNumber')
                ->add('bankSwiftCode')
                ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('bankOrder', 'integer', array('editable' => true))
                ->addIdentifier('bankTitle')
                ->add('bankTinNumber')
                ->add('bankSwiftCode');
    }
    
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'bankOrder'
    );
    
}
