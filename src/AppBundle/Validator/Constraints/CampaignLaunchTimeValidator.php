<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Custom validator to check that end date is greater than start date for the Launch object
 *
 * @author constantine
 *
 */
class CampaignLaunchTimeValidator extends ConstraintValidator
{
    public function validate($entity, Constraint $constraint)
    {
        if (!is_null($entity->getStart()) && !is_null($entity->getEnd())) {

            if ($entity->getEnd() <= $entity->getStart()) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
