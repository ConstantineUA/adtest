<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\AppBundle;

/**
 * Repository to work with contentunits
 *
 * @author constantine
 *
 */
class ContentunitRepository extends EntityRepository
{
    /**
     * Finds a matching size for the given image
     *
     * @param UploadedFile $image
     * @return AppBundle\Entity\Contentunit
     */
    public function findByImage(UploadedFile $image)
    {
        $size = getimagesize($image->getPathname());

        return $this->findOneBy(array('width' => $size[0], 'height' => $size[1],));
    }

    /**
     * Returns the list of available dimensions according to stored contentunits
     *
     * @return array
     */
    public function findAllAvailableDimensions()
    {
        $query = $this->getEntityManager()->createQuery('SELECT c.width, c.height FROM AppBundle\Entity\Contentunit c');

        return $query->getArrayResult();
    }
}
