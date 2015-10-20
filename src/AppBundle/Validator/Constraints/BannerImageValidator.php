<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;

/**
 * Validator to check that an uploaded banner image has an appropriate dimension
 * (according to stored contentunits)
 *
 * @author constantine
 *
 */
class BannerImageValidator extends ConstraintValidator
{
    /**
     * Store a reference to the entity manager
     *
     * @var EntityManager
     */
    private $em;

    /**
     * Inject dependencies
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) { // i guess it's EntityManager the type
        $this->em = $em;
    }

    /**
     * Checks that an image size is among valid dimensions
     *
     * @see \Symfony\Component\Validator\ConstraintValidatorInterface::validate()
     */
    public function validate($image, Constraint $constraint)
    {
        if (!$image) {
            return;
        }

        $size = getimagesize($image->getPathname());

        if ($size) {
            $repository = $this->em->getRepository('AppBundle\Entity\Contentunit');

            $contentunit = $repository->findByImage($image);

            if (!$contentunit) {
                $allDimensions = array_map(function ($dimension) {
                    return $dimension['width'] . '*' . $dimension['height'];
                }, $repository->findAllAvailableDimensions());

                $this->context->buildViolation($constraint->message)
                    ->setParameter('%dimensions%', implode(',', $allDimensions))
                    ->addViolation();
            }
        }
    }
}
