<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use AppBundle\Form\Type\TranslatedFieldType;

use AppBundle\Entity\Page;

class PageAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $myEntity = new Page();
        
        $formMapper
                ->add('pageTitle', 'translatable_field', array(
                    'field'                => 'pageTitle',
                    'personal_translation' => 'AppBundle\Entity\Translation\PageTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('pageText', 'translatable_field', array(
                    'field'          => 'pageText',
                    'personal_translation' => '\AppBundle\Entity\Translation\PageTranslation',
                    'property_path'  => 'translations',
                    'widget' => 'textarea',
                    'attr' => array('class' => 'ckeditor')
                ))
                ->add('pageMetaKeywords', 'translatable_field', array(
                    'field'                => 'pageMetaKeywords',
                    'personal_translation' => 'AppBundle\Entity\Translation\PageTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('pageMetaDescription', 'translatable_field', array(
                    'field'                => 'pageMetaDescription',
                    'personal_translation' => 'AppBundle\Entity\Translation\PageTranslation',
                    'property_path'        => 'translations',
                ))
                ->add('pageOgImage', 'comur_image', array(
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

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('pageTitle')
                ;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('delete');
    }
    
}
