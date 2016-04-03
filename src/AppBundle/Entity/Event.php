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
     * @ORM\Column(unique=true)
     * @Assert\NotBlank()
     */
    protected $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="Lang", referencedColumnName="code")
     **/
    protected $language;
    
    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="Status", referencedColumnName="code")
     **/
    protected $status;   
    
    /**
     * @ORM\Column(name="SortOrder")
     * @Assert\NotBlank()
     */
    protected $sortOrder;
    
    /**
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="PageId", referencedColumnName="id")
     **/
    protected $page;
    
    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="ArticleId", referencedColumnName="id")
     **/
    protected $article;



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
     * @return Event
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
     * Set sortOrder
     *
     * @param string $sortOrder
     * @return Event
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return string 
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * Set language
     *
     * @param \AppBundle\Entity\Language $language
     * @return Event
     */
    public function setLanguage(\AppBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \AppBundle\Entity\Language 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\Status $status
     * @return Event
     */
    public function setStatus(\AppBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\Status 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set page
     *
     * @param \AppBundle\Entity\Page $page
     * @return Event
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
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     * @return Event
     */
    public function setArticle(\AppBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }
}
