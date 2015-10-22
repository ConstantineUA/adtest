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
    public $message = "Wrong image dimension (accepted dimensions for the contentunit are less then %dimension%)";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'banner_image_validator';
    }
}
