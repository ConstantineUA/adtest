<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\AppBundle;

/**
 * Repository to work with launch objects
 *
 * @author constantine
 *
 */
class LaunchRepository extends EntityRepository
{
    /**
     * Find a launch object linked to the given campaign
     *
     * @param int $categoryId
     */
    public function findOneByCategoryForRender($categoryId)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT
                l
            FROM AppBundle:Launch l
            WHERE l.campaign = :id'
        )->setParameter('id', $categoryId);

        return $query->getOneOrNullResult($query::HYDRATE_ARRAY);
    }
}
