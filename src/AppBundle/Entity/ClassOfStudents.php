<?php

// src/AppBundle/Entity/ClassOfStudents.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use AppBundle\Entity\Year;
use AppBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="Class")
 */
class ClassOfStudents
{
       
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(name="EnglishName", unique=true)
     * @Assert\NotBlank()
     */
    protected $englishName;    
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    protected $ordinal;

    /**
     * @ORM\ManyToOne(targetEntity="Year")
     * @ORM\JoinColumn(name="YearId", referencedColumnName="id")
     */
    protected $year;

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
     * @return ClassOfStudents
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
     * Set ordinal
     *
     * @param integer $ordinal
     * @return ClassOfStudents
     */
    public function setOrdinal($ordinal)
    {
        $this->ordinal = $ordinal;

        return $this;
    }

    /**
     * Get ordinal
     *
     * @return integer 
     */
    public function getOrdinal()
    {
        return $this->ordinal;
    }

    /**
     * Set year
     *
     * @param \AppBundle\Entity\Year $year
     * @return ClassOfStudents
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
     * Set englishName
     *
     * @param string $englishName
     * @return ClassOfStudents
     */
    public function setEnglishName($englishName)
    {
        $this->englishName = $englishName;

        return $this;
    }

    /**
     * Get englishName
     *
     * @return string 
     */
    public function getEnglishName()
    {
        return $this->englishName;
    }
}
