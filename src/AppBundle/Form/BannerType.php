<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form to work with banners
 *
 * @author constantine
 *
 */
class BannerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('caption')
            ->add('clickurl')
            ->add('contentunits', 'entity', array(
                'class' => 'AppBundle\Entity\Contentunit',
                'choice_label' => 'name',
            ))
            ->add('imageFile', 'app_banner_image', array('required' => false,))

            ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'appbundle_banner';
    }

}
