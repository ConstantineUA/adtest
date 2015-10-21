<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint to show an invalid interval for the Launch object
 *
 * @Annotation
 * @author constantine
 *
 */
class CampaignLaunchTime extends Constraint
{
    public $message = "Start date has to be lower than end date!";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'campaign_launch_date_validator';
    }
}
