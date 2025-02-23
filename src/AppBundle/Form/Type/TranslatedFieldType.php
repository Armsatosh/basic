<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Form\EventListener\AddTranslatedFieldSubscriber;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslatedFieldType extends AbstractType
{
    
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        if(! class_exists($options['personal_translation']))
        {
            Throw new \InvalidArgumentException(sprintf("Unable to find personal translation class: '%s'", $options['personal_translation']));
        }
        
        if(! $options['field'])
        {
            Throw new \InvalidArgumentException("You should provide a field to translate");
        }
        
        $subscriber = new AddTranslatedFieldSubscriber($builder->getFormFactory(), $this->container, $options);
        $builder->addEventSubscriber($subscriber);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults($this->getDefaultOptions());
    }

    public function getDefaultOptions(array $options = array())
    {
        $options['remove_empty'] = true; //Personal Translations without content are removed
        $options['csrf_protection'] = false;
        $options['personal_translation'] = false; //Personal Translation class
        $options['locales'] = array('hy', 'en', 'ru'); //the locales you wish to edit
        $options['required_locale'] = array($this->container->getParameter('locale')); //the required locales cannot be blank
        $options['field'] = false; //the field that you wish to translate
        $options['widget'] = "text"; //change this to another widget like 'texarea' if needed
        $options['entity_manager_removal'] = true; //auto removes the Personal Translation thru entity manager
        $options['attr'] = [];
        return $options;
    }

    public function getName()
    {
        return 'translatable_field';
    }
    
}