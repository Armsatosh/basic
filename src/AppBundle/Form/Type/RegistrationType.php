<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Profiles;

use AppBundle\Form\Type\ProfileType;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {
//        $builder->add('profile', new ProfileType());
        $builder->remove('username');
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix() {
        return 'app_user_registration';
    }

    public function getName() {
        return $this->getBlockPrefix();
    }

}