<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', 'textarea', array('required' => false))
            ->add('banners', 'entity', array(
                'class' => 'AppBundle:Banner',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ))

            ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'appbundle_campaign';
    }
}
