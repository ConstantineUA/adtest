<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

/**
 * Custom repository to deal with banners
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
     * Fetch a random banner out of available ones to send as an advertisement
     *
     * @param mixed $contentunit either null (no preference) or string (contentunit code)
     * @param mixed $campaign either null (no preference) or string (campaign code)
     * @return array
     */
    public function findOneForAdvertisement($contentunit, $campaign)
    {
        $em = $this->getEntityManager();

        // fetch random launched campaign firstly
        $qb = $em->createQueryBuilder()
            ->select(array(
                'c.id AS campaignId', 'l.id AS launchId', 'RAND() as HIDDEN rand',
            ))
            ->from('AppBundle:Launch', 'l')
            ->innerJoin('l.campaign', 'c')
            ->where('l.hits < l.limit')
            ->andWhere('l.start <= CURRENT_TIMESTAMP()')
            ->andWhere('l.end >= CURRENT_TIMESTAMP()')
            ->orderBy('rand')
            ->setMaxResults(1);

        if (!is_null($contentunit)) {
            $qb->join('c.banners', 'b')
                ->join('b.contentunits', 'cnt')
                ->groupBy('l.id')
                ->andWhere('cnt.code = :code')->setParameter('code', $contentunit);
        }

        if (!is_null($campaign)) {
            $qb->andWhere('c.slug = :slug')->setParameter('slug', $campaign);
        }

        $queryCampaign = $qb->getQuery();
        $data = $queryCampaign->getOneOrNullResult($queryCampaign::HYDRATE_ARRAY);

        if (!$data) {
            return array();
        }

        // and then add a random bannner from the fetched campaign
        $queryBanner = $em->createQuery(
            'SELECT
                b.name,
                b.caption,
                b.clickurl,
                b.imageName,
                cnt.width,
                cnt.height,
                RAND() as HIDDEN rand
            FROM AppBundle:Banner b
            JOIN b.campaigns c
            JOIN b.contentunits cnt
            WHERE c.id = :id
            ORDER BY rand'
        )->setParameter('id', $data['campaignId'])
        ->setMaxResults(1);

        $banner = $queryBanner->getSingleResult($queryBanner::HYDRATE_ARRAY);
        $data = array_merge($data, $banner);

        return $data;
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
                'b.id', 'b.name', 'b.caption', 'b.clickurl', 'b.imageName', 'cnt.code AS contentunit_code',
            ))
            ->from('AppBundle\Entity\Banner', 'b')
            ->leftJoin('b.contentunits', 'cnt')
            ->where('b.user = :user')
            ->orderBy('b.updatedAt', 'DESC');

        return $qb;
    }
}
