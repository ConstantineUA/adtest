<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

/**
 * Custom repository to deals with banners
 *
 * @author constantine
 *
 */
class BannerRepository extends EntityRepository
{
    /**
     * Checks if given banner is allowed to modify for the current user
     *
     * @param User $user
     * @param Banner $banner
     * @return boolean
     */
    public function isAllowedToModify(User $user, Banner $banner)
    {
        return $user === $banner->getUser();
    }

    /**
     * Returns the array of banners to render for the given user
     *
     * @param UserBundle\Entity\User $user
     * @return array
     */
    public function findAllByUserForRender(User $user)
    {
        $query = $this->getBasicQueryBuilderForRender()
            ->setParameter('user', $user)
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * Returns the array of banners to render for the given user and category id
     *
     * @param User $user
     * @param int $categoryId
     * @return array
     */
    public function findAllByUserAndCategoryForRender(User $user, $categoryId)
    {
        $query = $this->getBasicQueryBuilderForRender()
            ->join('b.campaigns', 'c')
            ->andWhere('c.id = :id')
            ->setParameters(array(
                'user' => $user,
                'id' => $categoryId,

            ))
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * Creates the basic Doctrine query builder with all necessary fields to render a banner
     *
     * @return Doctrine\ORM\QueryBuilder
     */
    protected function getBasicQueryBuilderForRender()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select(array(
                'b.id', 'b.name', 'b.caption', 'b.clickurl', 'b.imageName', 'cnt.code AS contentunit_code'
            ))
            ->from('AppBundle\Entity\Banner', 'b')
            ->leftJoin('b.contentunits', 'cnt')
            ->where('b.user = :user')
            ->orderBy('b.updatedAt', 'DESC');

        return $qb;
    }
}
