<?php

// src/AppBundle/Entity/ExamType.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="EventType")
 */
class EventType
{
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\Column(name="EnTitle", unique=true)
     * @Assert\NotBlank()
     */
    protected $enTitle;
    
    /**
     * @ORM\Column(name="RuTitle", unique=true)
     * @Assert\NotBlank()
     */
    protected $ruTitle;

     /**
     * @ORM\Column(name="EnDescription")
     * @Assert\NotBlank()
     */
    protected $enDescription;
    
    /**
     * @ORM\Column(name="RuDescription")
     * @Assert\NotBlank()
     */
    protected $ruDescription;


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
     * Set enTitle
     *
     * @param string $enTitle
     * @return EventType
     */
    public function setEnTitle($enTitle)
    {
        $this->enTitle = $enTitle;

        return $this;
    }

    /**
     * Get enTitle
     *
     * @return string 
     */
    public function getEnTitle()
    {
        return $this->enTitle;
    }

    /**
     * Set ruTitle
     *
     * @param string $ruTitle
     * @return EventType
     */
    public function setRuTitle($ruTitle)
    {
        $this->ruTitle = $ruTitle;

        return $this;
    }

    /**
     * Get ruTitle
     *
     * @return string 
     */
    public function getRuTitle()
    {
        return $this->ruTitle;
    }

    /**
     * Set enDescription
     *
     * @param string $enDescription
     * @return EventType
     */
    public function setEnDescription($enDescription)
    {
        $this->enDescription = $enDescription;

        return $this;
    }

    /**
     * Get enDescription
     *
     * @return string 
     */
    public function getEnDescription()
    {
        return $this->enDescription;
    }

    /**
     * Set ruDescription
     *
     * @param string $ruDescription
     * @return EventType
     */
    public function setRuDescription($ruDescription)
    {
        $this->ruDescription = $ruDescription;

        return $this;
    }

    /**
     * Get ruDescription
     *
     * @return string 
     */
    public function getRuDescription()
    {
        return $this->ruDescription;
    }
}
