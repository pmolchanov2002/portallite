<?php

// src/AppBundle/Entity/Banner.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Banner")
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
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $description;
    
    /**
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $name;
    
    /**
     * @ORM\ManyToMany(targetEntity="Media")
     * @ORM\JoinTable(name="Banner_Media",
     *      joinColumns={@ORM\JoinColumn(name="BannerId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="MediaId", referencedColumnName="id")}
     *      )
     **/
    protected $media;
    
    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="banner")
     * @ORM\JoinColumn(name="BannerId", referencedColumnName="id")
     **/
    protected $pages;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param string $description
     * @return Banner
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
     * Set name
     *
     * @param string $name
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
     * Set page
     *
     * @param \AppBundle\Entity\Page $page
     * @return Banner
     */
    public function setPage(\AppBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \AppBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Add media
     *
     * @param \AppBundle\Entity\Media $media
     * @return Banner
     */
    public function addMedia(\AppBundle\Entity\Media $media)
    {
        $this->media[] = $media;

        return $this;
    }

    /**
     * Remove media
     *
     * @param \AppBundle\Entity\Media $media
     */
    public function removeMedia(\AppBundle\Entity\Media $media)
    {
        $this->media->removeElement($media);
    }

    /**
     * Get media
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Add pages
     *
     * @param \AppBundle\Entity\Page $pages
     * @return Banner
     */
    public function addPage(\AppBundle\Entity\Page $pages)
    {
        $this->pages[] = $pages;

        return $this;
    }

    /**
     * Remove pages
     *
     * @param \AppBundle\Entity\Page $pages
     */
    public function removePage(\AppBundle\Entity\Page $pages)
    {
        $this->pages->removeElement($pages);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPages()
    {
        return $this->pages;
    }
}
