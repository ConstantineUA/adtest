<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Contentunit;

/**
 * Banner entity class
 *
 * @ORM\Entity
 * @ORM\Table(name="ads_banners")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BannerRepository")
 * @Vich\Uploadable
 */
class Banner
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $caption;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected $clickurl;

    /**
     * @ORM\ManyToMany(targetEntity="Contentunit")
     * @ORM\JoinTable(
     *     name="ads_banners_contentunits",
     *     joinColumns={
     *         @ORM\JoinColumn(name="banner_id", referencedColumnName="id", onDelete="CASCADE")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="contentunit_id", referencedColumnName="id", onDelete="CASCADE")
     *     }
     * )
     **/
    protected $contentunits;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="banners")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @Vich\UploadableField(mapping="banner_image", fileNameProperty="imageName")
     *
     * @var File
     */
    protected $imageFile;

    public function __construct()
    {
        $this->contentunits = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValueOnPrePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValueOnPreUpdate()
    {
        $this->updatedAt = new \DateTime();
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
     * @return Banner
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
     * Set caption
     *
     * @param string $caption
     *
     * @return Banner
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set clickurl
     *
     * @param string $clickurl
     *
     * @return Banner
     */
    public function setClickurl($clickurl)
    {
        $this->clickurl = $clickurl;

        return $this;
    }

    /**
     * Get clickurl
     *
     * @return string
     */
    public function getClickurl()
    {
        return $this->clickurl;
    }

    /**
     * Set contentunit
     *
     * @param Contentunit $contentunit
     *
     * @return Banner
     */
    public function setContentunit(Contentunit $contentunit = null)
    {
        $this->contentunit = $contentunit;

        return $this;
    }

    /**
     * Get contentunit
     *
     * @return Contentunit
     */
    public function getContentunit()
    {
        return $this->contentunit;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }
    }

    /**
     *
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Banner
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add contentunit
     *
     * @param Contentunit $contentunit
     *
     * @return Banner
     */
    public function addContentunit(Contentunit $contentunit)
    {
        $this->contentunits[] = $contentunit;

        return $this;
    }

    /**
     * Remove contentunit
     *
     * @param Contentunit $contentunit
     */
    public function removeContentunit(Contentunit $contentunit)
    {
        $this->contentunits->removeElement($contentunit);
    }

    /**
     * Get contentunits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContentunits()
    {
        return $this->contentunits;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Banner
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
}
