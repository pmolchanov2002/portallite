<?php

// src/AppBundle/Entity/Banner.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\BannerMediaRef;
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
     * @ORM\OneToMany(targetEntity="BannerMediaRef", mappedBy="banner", cascade={"persist"})
     * @ORM\OrderBy({"ordinal" = "ASC"})
     **/
    protected $mediaRefs;
    
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
     * Get media
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function clearMedia()
    {
    	$this->media =  new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaRefs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add mediaRefs
     *
     * @param \AppBundle\Entity\BannerMediaRef $mediaRefs
     * @return Banner
     */
    public function addMediaRef(\AppBundle\Entity\BannerMediaRef $mediaRefs)
    {
        $this->mediaRefs[] = $mediaRefs;

        return $this;
    }

    /**
     * Remove mediaRefs
     *
     * @param \AppBundle\Entity\BannerMediaRef $mediaRefs
     */
    public function removeMediaRef(\AppBundle\Entity\BannerMediaRef $mediaRefs)
    {
        $this->mediaRefs->removeElement($mediaRefs);
    }

    /**
     * Get mediaRefs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMediaRefs()
    {
        return $this->mediaRefs;
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
