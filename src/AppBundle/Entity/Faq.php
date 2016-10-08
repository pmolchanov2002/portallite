<?php

// src/AppBundle/Entity/Article.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Faq")
 */
class Faq
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
    protected $title;
    

    /**
     * @ORM\Column(name="Content", type="blob")
     * @Assert\NotBlank()
     */
    protected $content;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\ManyToMany(targetEntity="Page")
     * @ORM\JoinTable(name="Page_Faq",
     *      joinColumns={@ORM\JoinColumn(name="FaqId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="PageId", referencedColumnName="id")}
     *      )
     **/
    protected $pages;
    
    /**
     * @ORM\Column(name="Ordinal")
     * @Assert\NotBlank()
     */
    protected $ordinal;
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set title
     *
     * @param string $title
     * @return Faq
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Faq
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
    	if ($this->content != '')
    		return stream_get_contents($this->content);
    	return $this->content;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Faq
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set ordinal
     *
     * @param string $ordinal
     * @return Faq
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
     * Add pages
     *
     * @param \AppBundle\Entity\Page $pages
     * @return Faq
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
