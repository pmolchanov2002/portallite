<?php

// src/AppBundle/Entity/Event.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Event")
 */
class Event
{
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="EventType")
     * @ORM\JoinColumn(name="EventTypeId", referencedColumnName="id")
     **/
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Year")
     * @ORM\JoinColumn(name="YearId", referencedColumnName="id")
     **/
    protected $year;
    
    /**
     * @ORM\Column(name="EventDate", type="datetime")
     */
    protected $eventDate;
    
    /**
     * @ORM\ManyToOne(targetEntity="Media")
     * @ORM\JoinColumn(name="IconId", referencedColumnName="id")
     **/
    protected $icon;
    

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
     * Set type
     *
     * @param \AppBundle\Entity\EventType $type
     * @return Event
     */
    public function setType(\AppBundle\Entity\EventType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\EventType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set year
     *
     * @param \AppBundle\Entity\Year $year
     * @return Event
     */
    public function setYear(\AppBundle\Entity\Year $year = null)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \AppBundle\Entity\Year 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set icon
     *
     * @param \AppBundle\Entity\Media $icon
     * @return Event
     */
    public function setIcon(\AppBundle\Entity\Media $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return \AppBundle\Entity\Media 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     * @return Event
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }
}
