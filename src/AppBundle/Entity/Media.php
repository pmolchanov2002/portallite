<?php

// src/AppBundle/Entity/Media.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Media")
 */
class Media
{
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $description;
    
    /**
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $path;
    
    /**
     * @ORM\Column()
     */
    protected $width;
    
    /**
     * @ORM\Column()
     */
    protected $height;
    
    /**
     * @ORM\ManyToOne(targetEntity="MediaType")
     * @ORM\JoinColumn(name="TypeId", referencedColumnName="id")
     **/
    protected $type;
    
    /**
     * @ORM\Column(name="EnglishName", unique=true)
     * @Assert\NotBlank()
     */
    protected $englishName;

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
     * Set description
     *
     * @param string $description
     * @return Media
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
     * Set path
     *
     * @param string $path
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set width
     *
     * @param string $width
     * @return Media
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return string 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param string $height
     * @return Media
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return string 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\MediaType $type
     * @return Media
     */
    public function setType(\AppBundle\Entity\MediaType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\MediaType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set englishName
     *
     * @param string $englishName
     * @return Media
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
