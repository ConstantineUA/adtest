<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;
use AppBundle\AppBundle;

/**
 * Custom repository to deals with banners
 *
 * @author constantine
 *
 */
class BannerRepository extends EntityRepository
{
    /**
     * Returns the array of banners to render for the given user
     *
     * @param UserBundle\Entity\User $user
     * @return array
     */
    public function findByUserForRender(User $user)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT
                b.id,
                b.name,
                b.caption,
                b.clickurl,
                b.imageName,
                c.code
            FROM AppBundle\Entity\Banner b
            JOIN b.contentunits c
            WHERE b.user = :user
            ORDER BY b.updatedAt DESC'
        )->setParameter('user', $user);

        return $query->getArrayResult();
    }
}
