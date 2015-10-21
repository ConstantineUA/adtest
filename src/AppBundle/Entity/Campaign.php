<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Banner;

/**
 * Campaign entity class
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="ads_campaigns")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CampaignRepository", readOnly=true)
 */
class Campaign
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\Length(max=128)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="campaigns")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\ManyToMany(targetEntity="Banner", inversedBy="campaigns")
     * @ORM\JoinTable(name="ads_campaigns_banners")
     **/
    protected $banners;

    /**
     *
     * @ORM\OneToMany(targetEntity="Launch", mappedBy="campaign")
     */
    protected $launches;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->banners = new ArrayCollection();
        $this->launches = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValueOnPrePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Campaign
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Campaign
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Campaign
     */
    public function setUser(\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add banner
     *
     * @param \AppBundle\Entity\Banner $banner
     *
     * @return Campaign
     */
    public function addBanner(Banner $banner)
    {
        $this->banners[] = $banner;

        return $this;
    }

    /**
     * Remove banner
     *
     * @param \AppBundle\Entity\Banner $banner
     */
    public function removeBanner(Banner $banner)
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
     * Add launch
     *
     * @param \AppBundle\Entity\Launch $launch
     *
     * @return Campaign
     */
    public function addLaunch(\AppBundle\Entity\Launch $launch)
    {
        $this->launches[] = $launch;

        return $this;
    }

    /**
     * Remove launch
     *
     * @param \AppBundle\Entity\Launch $launch
     */
    public function removeLaunch(\AppBundle\Entity\Launch $launch)
    {
        $this->launches->removeElement($launch);
    }

    /**
     * Get launches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLaunches()
    {
        return $this->launches;
    }
}
