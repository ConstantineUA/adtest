<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

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
        return 'app_banner_image';
    }
}
