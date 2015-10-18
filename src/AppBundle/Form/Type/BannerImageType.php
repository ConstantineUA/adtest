<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Custom field to upload a banner image
 * (adds current image preview before the input)
 *
 * @author constantine
 */
 class BannerImageType extends AbstractType
{
    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'banner_image';
    }
}
