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
     * Store absolute path of banners image directory
     *
     * @var string
     */
    private $imagesPath;

    /**
     * Inject dependencies
     *
     * @param ContentunitRepository $em
     */
    public function __construct(ContentunitRepository $repository, $imagesPath)
    {
        $this->repository = $repository;
        $this->imagesPath = $imagesPath;
    }

    /**
     * Checks that an image size is among valid dimensions
     *
     * @see \Symfony\Component\Validator\ConstraintValidatorInterface::validate()
     */
    public function validate($entity, Constraint $constraint)
    {
        $pathname = $this->getImagePathname($entity);

        if (!$pathname) {
            return;
        }

        // for the sake of simplicity presume that a banner image
        // has to be at least 20 pixels less than a contentunit
        $minAllowedPadding = 20;

        $contentunit = $entity->getContentunits()->first();
        $size = getimagesize($pathname);

        if ($size[0] - $contentunit->getWidth() > $minAllowedPadding
            || $size[1] - $contentunit->getHeight() > $minAllowedPadding
        ) {
            $allowedWidth = $contentunit->getWidth() - $minAllowedPadding;
            $allowedHeight = $contentunit->getHeight() - $minAllowedPadding;

            $this->context->buildViolation($constraint->message)
                ->setParameter('%dimension%', implode('*', array($allowedWidth, $allowedHeight)))
                ->addViolation();
        }
    }

    /**
     * Generate a full pathname for a banner image
     *
     * @param AppBundle\Entity\Banner $entity
     * @return string
     */
    protected function getImagePathname($entity)
    {
        $pathname = '';

        if ($entity->getImageFile()) {
            $pathname = $entity->getImageFile()->getPathname();
        } else if ($entity->getImageName()) {
            $pathname = $this->imagesPath . '/' . $entity->getImageName();
        }

        return $pathname;
    }
}
