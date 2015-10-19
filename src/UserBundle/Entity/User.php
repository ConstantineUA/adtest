<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User entity class
 *
 * @ORM\Entity
 * @ORM\Table(name="ads_users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Banner", mappedBy="user", cascade={"remove"})
     */
    protected $banners;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Campaign", mappedBy="user", cascade={"remove"})
     */
    protected $campaigns;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add banner
     *
     * @param \AppBundle\Entity\Banner $banner
     *
     * @return User
     */
    public function addBanner(\AppBundle\Entity\Banner $banner)
    {
        $this->banners[] = $banner;

        return $this;
    }

    /**
     * Remove banner
     *
     * @param \AppBundle\Entity\Banner $banner
     */
    public function removeBanner(\AppBundle\Entity\Banner $banner)
    {
        $this->banners->removeElement($banner);
    }

    /**
     * Get banners
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * Add campaign
     *
     * @param \AppBundle\Entity\Campaign $campaign
     *
     * @return User
     */
    public function addCampaign(\AppBundle\Entity\Campaign $campaign)
    {
        $this->campaigns[] = $campaign;

        return $this;
    }

    /**
     * Remove campaign
     *
     * @param \AppBundle\Entity\Campaign $campaign
     */
    public function removeCampaign(\AppBundle\Entity\Campaign $campaign)
    {
        $this->campaigns->removeElement($campaign);
    }

    /**
     * Get campaigns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCampaigns()
    {
        return $this->campaigns;
    }
}
