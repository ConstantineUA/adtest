<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contentunit entity class
 *
 * @ORM\Entity
 * @ORM\Table(name="ads_contentunits")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ContentunitRepository")
 */
class Contentunit
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
     * @ORM\Column(type="string", length=64)
     */
    protected $code;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $width;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $height;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

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
     * @return Contentunit
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
     * Set code
     *
     * @param string $code
     *
     * @return Contentunit
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return Contentunit
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set heigh
     *
     * @param integer $heigh
     *
     * @return Contentunit
     */
    public function setHeigh($heigh)
    {
        $this->heigh = $heigh;

        return $this;
    }

    /**
     * Get heigh
     *
     * @return integer
     */
    public function getHeigh()
    {
        return $this->heigh;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Contentunit
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
}
