<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Campaign;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as FormAssert;

/**
 * Campaign entity class
 *
 * @ORM\Entity
 * @ORM\Table(name="ads_campaigns_launches")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\LaunchRepository")
 * @FormAssert\CampaignLaunchTime()
 */
class Launch
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Range(min = "now")
     * @Assert\DateTime()
     *
     * @var \DateTime
     */
    protected $start;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     *
     * @var \DateTime
     */
    protected $end;

    /**
     * @ORM\Column(type="integer")
     */
    protected $hits = 0;

    /**
     * @ORM\Column(type="integer", name="_limit")
     * @Assert\Range(min = 1)
     */
    protected $limit;

    /**
     * @ORM\ManyToOne(targetEntity="Campaign", inversedBy="launches")
     * @ORM\JoinColumn(onDelete="CASCADE")
     **/
    protected $campaign;

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
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Launch
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Launch
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set hits
     *
     * @param integer $hits
     *
     * @return Launch
     */
    public function setHits($hits)
    {
        $this->hits = $hits;

        return $this;
    }

    /**
     * Increment hits
     *
     * @return Launch
     */
    public function incrementHits()
    {
        $this->setHits($this->getHits() + 1);

        return $this;
    }

    /**
     * Get hits
     *
     * @return integer
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * Set limit
     *
     * @param integer $limit
     *
     * @return Launch
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get limit
     *
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set campaign
     *
     * @param \AppBundle\Entity\Campaign $campaign
     *
     * @return Launch
     */
    public function setCampaign(Campaign $campaign = null)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get campaign
     *
     * @return \AppBundle\Entity\Campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }
}
