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
     * Check if allowed to launch a given campaign
     *
     * @param User $user
     * @param Campaign $campaign
     * @return boolean
     */
    public function isAllowedToAddLaunch(User $user, Campaign $campaign)
    {
        return $campaign->getUser() === $user && $campaign->getLaunches()->isEmpty();
    }

    /**
     * Fetches the necessary fields to render campaigns list
     *
     * @param User $user
     */
    public function findAllByUserForRender(User $user)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT
                c.id,
                c.name,
                c.description
            FROM AppBundle:Campaign c
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
    public function findOneByIdForRender(User $user, $id)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT
                c.id,
                c.name,
                c.description,
                c.slug
            FROM AppBundle:Campaign c
            WHERE c.id = :id AND c.user = :user'
        )->setParameters(array(
            'id' =>  $id,
            'user' => $user,
        ));

        $campaign = $query->getOneOrNullResult($query::HYDRATE_ARRAY);

        if ($campaign) {
            $em = $this->getEntityManager();

            $campaign['banners'] = $em->getRepository('AppBundle:Banner')->findAllByUserAndCategoryForRender($user, $id);
            $campaign['contentunits'] = array_column($campaign['banners'], 'contentunit_code');
            $campaign['launch'] = $em->getRepository('AppBundle:Launch')->findOneByCategoryForRender($id);
        }

        return $campaign;
    }
}
