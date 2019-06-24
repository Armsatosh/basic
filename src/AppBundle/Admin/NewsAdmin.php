<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\TranslationBundle\Filter\TranslationFieldFilter;
use ToolBox\FileBrowserBundle\Form\Type\FileBrowserType;

class NewsAdmin extends AbstractAdmin
{

    public $tbOptions = array(
        'multiple' => false,
        'image_directory' => '/img/news',
        'thumbWidth' => 569,
        'thumbHeight' => 398,
        'cropOptions' => array(
            0 => array(
                'og' => array(
                    "title" => "Open Graph (facebook)",
                    "type" => "pixel",
                    "width" => 1200,
                    "height" => 630
                ),
                'thumb' => array(
                    "title" => "Thumbnail",
                    "type" => "pixel",
                    "width" => 569,
                    "height" => 398
                )
            )
        )
    );

    public function configure()
    {
        parent::configure();

        $this->setTemplate('edit', 'SonataAdminBundle:CRUD:tb_file_browser_edit.html.twig');

    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('newsTitle', 'translatable_field', array(
                'field'                => 'newsTitle',
                'personal_translation' => 'AppBundle\Entity\Translation\NewsTranslation',
                'property_path'        => 'translations',
            ))
            ->add('newsDate')
//            ->add('newsText', null, array(
//                'attr' => array('class' => 'ckeditor')
//            ))
            ->add('newsText', 'translatable_field', array(
                'field'          => 'newsText',
                'personal_translation' => '\AppBundle\Entity\Translation\NewsTranslation',
                'property_path'  => 'translations',
                'widget' => 'textarea',
                'attr' => array('class' => 'ckeditor')
            ))
            ->add('newsMetaKeywords', 'translatable_field', array(
                'field'                => 'newsMetaKeywords',
                'personal_translation' => 'AppBundle\Entity\Translation\NewsTranslation',
                'property_path'        => 'translations',
            ))
            ->add('newsMetaDescription', 'translatable_field', array(
                'field'                => 'newsMetaDescription',
                'personal_translation' => 'AppBundle\Entity\Translation\NewsTranslation',
                'property_path'        => 'translations',
            ))
            ->add('newsOgImage', FileBrowserType::class, array(
                'options' => array(
                    'multiple' => false
                )
            ))
            ->add('newsGallery', FileBrowserType::class, array(
                'options' => array(
                    'multiple' => true
                )
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('newsTitle', TranslationFieldFilter::class)
            ->add('newsDate')
            ->add('newsText', TranslationFieldFilter::class)
            ->add('newsMetaKeywords', TranslationFieldFilter::class)
            ->add('newsMetaDescription', TranslationFieldFilter::class)
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('newsTitle')
            ->add('newsDate')
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array()
                )
            ))
        ;
    }

}