<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LaunchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', 'datetime', array(
                'data' => new \DateTime('+10 minutes'),
                'date_widget' => 'single_text',
            ))
            ->add('end', 'datetime', array(
                'data' => new \DateTime('+3 weeks'),
                'date_widget' => 'single_text',
            ))
            ->add('limit', 'text')

            ->add('save', 'submit')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_launch';
    }
}
