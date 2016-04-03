<?php

// src/AppBundle/Entity/MediaType.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="MediaType")
 */
class MediaType
{
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\Column(unique=true)
     * @Assert\NotBlank()
     */
    protected $name;
    
    /**
     * @ORM\Column(name="MimeType")
     * @Assert\NotBlank()
     */
    protected $mimeType;
    
    /**
     * @ORM\Column(name="IconClass")
     * @Assert\NotBlank()
     */
    protected $iconClass;

    /**
     * @ORM\Column(name="IconPath")
     * @Assert\NotBlank()
     */
    protected $iconPath;

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
     * @return MediaType
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
     * Set mimeType
     *
     * @param string $mimeType
     * @return MediaType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set iconClass
     *
     * @param string $iconClass
     * @return MediaType
     */
    public function setIconClass($iconClass)
    {
        $this->iconClass = $iconClass;

        return $this;
    }

    /**
     * Get iconClass
     *
     * @return string 
     */
    public function getIconClass()
    {
        return $this->iconClass;
    }

    /**
     * Set iconPath
     *
     * @param string $iconPath
     * @return MediaType
     */
    public function setIconPath($iconPath)
    {
        $this->iconPath = $iconPath;

        return $this;
    }

    /**
     * Get iconPath
     *
     * @return string 
     */
    public function getIconPath()
    {
        return $this->iconPath;
    }
}
