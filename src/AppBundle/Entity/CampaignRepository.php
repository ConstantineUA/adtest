<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

/**
 * Custom repository for the Campaign Entity class
 *
 * @author constantine
 */
class CampaignRepository extends EntityRepository
{
    /**
     * Fetches the necessary fields to render campaigns list
     *
     * @param User $user
     */
    public function findByUserForRender(User $user)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT
                c.id,
                c.name,
                c.description
            FROM AppBundle\Entity\Campaign c
            WHERE c.user = :user
            ORDER BY c.id DESC'
        )->setParameter('user', $user);

        return $query->getArrayResult();
    }

    /**
     * Fetches a single category for the render along with the list of banners
     *
     * @param User $user
     * @param int $id
     * @return array
     */
    public function findByIdForRender(User $user, $id)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT
                c.id,
                c.name,
                c.description
            FROM AppBundle\Entity\Campaign c
            WHERE c.id = :id AND c.user = :user'
        )->setParameters(array(
            'id' =>  $id,
            'user' => $user,
        ));

        $campaign = $query->getOneOrNullResult($query::HYDRATE_ARRAY);
        if ($campaign) {
            $campaign['banners'] = $this->getEntityManager()->getRepository('AppBundle\Entity\Banner')->findByUserAndCategoryForRender($user, $id);
        }

        return $campaign;
    }
}
