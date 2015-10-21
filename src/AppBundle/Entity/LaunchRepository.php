<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\AppBundle;

class LaunchRepository extends EntityRepository
{
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
