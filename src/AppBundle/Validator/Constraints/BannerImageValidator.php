<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Entity\ContentunitRepository;

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
     * Store a reference to the contentunit repository
     *
     * @var ContentunitRepository
     */
    private $repository;

    /**
     * Inject dependencies
     *
     * @param ContentunitRepository $em
     */
    public function __construct(ContentunitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Checks that an image size is among valid dimensions
     *
     * @see \Symfony\Component\Validator\ConstraintValidatorInterface::validate()
     */
    public function validate($image, Constraint $constraint)
    {
        if (!$image || !getimagesize($image->getPathname())) {
            return;
        }

        $contentunit = $this->repository->findByImage($image);

        if (!$contentunit) {
            $allDimensions = array_map(function ($dimension) {
                return $dimension['width'] . '*' . $dimension['height'];
            }, $this->repository->findAllAvailableDimensions());

            $this->context->buildViolation($constraint->message)
                ->setParameter('%dimensions%', implode(',', $allDimensions))
                ->addViolation();
        }
    }
}
