<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint to show an invalid banner image file
 *
 * @Annotation
 * @author constantine
 *
 */
class BannerImage extends Constraint
{
    public $message = "Wrong image dimensions (accepted dimensions are: %dimensions%)";

    public function validatedBy()
    {
        return 'banner_image_validator';
    }
}
