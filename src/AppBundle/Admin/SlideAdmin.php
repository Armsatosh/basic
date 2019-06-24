<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use AppBundle\Entity\Slide;

class SlideAdmin extends AbstractAdmin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $myEntity = new Slide();
        
        $formMapper
                ->add('slideOrder', 'integer')
                ->add('slideImage', 'comur_image', array(
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
                            'minWidth' => 845,
                            'minHeight' => 300,
                            'aspectRatio' => true, //optional
                            'cropRoute' => 'comur_api_crop', //optional
                            'forceResize' => false, //optional
                            'thumbs' => array(//optional
                                array(
                                    'maxWidth' => 845,
                                    'maxHeight' => 300,
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
                ->addIdentifier('slideOrder')
                ;
    }
    
}
