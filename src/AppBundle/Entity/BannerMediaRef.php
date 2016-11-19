<?php

// src/AppBundle/Entity/Banner.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Banner;
use AppBundle\Entity\Media;

/**
 * @ORM\Entity
 * @ORM\Table(name="Banner_Media")
 */
class BannerMediaRef
{
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Banner", inversedBy="mediaRefs")
     * @ORM\JoinColumn(name="BannerId", referencedColumnName="id")
	 */
    protected $banner;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="bannerRefs")
     * @ORM\JoinColumn(name="MediaId", referencedColumnName="id")
     */
    protected $media;
    
    /**
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $ordinal;

    /**
     * Set ordinal
     *
     * @param string $ordinal
     * @return BannerMediaRef
     */
    public function setOrdinal($ordinal)
    {
        $this->ordinal = $ordinal;

        return $this;
    }

    /**
     * Get ordinal
     *
     * @return string 
     */
    public function getOrdinal()
    {
        return $this->ordinal;
    }

    /**
     * Set banner
     *
     * @param \AppBundle\Entity\Banner $banner
     * @return BannerMediaRef
     */
    public function setBanner(\AppBundle\Entity\Banner $banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return \AppBundle\Entity\Banner 
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set media
     *
     * @param \AppBundle\Entity\Media $media
     * @return BannerMediaRef
     */
    public function setMedia(\AppBundle\Entity\Media $media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \AppBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }
}
