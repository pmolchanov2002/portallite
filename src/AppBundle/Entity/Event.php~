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
     * @ORM\Column(name="likeCount")
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    protected $likeCount;    
    
    /**
     * @ORM\Column(unique=true)
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */    
    
    protected $date;
    
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
     * Set englishName
     *
     * @param string $englishName
     * @return Event
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

    /**
     * Set description
     *
     * @param string $description
     * @return Event
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
     * Set englishDescription
     *
     * @param string $englishDescription
     * @return Event
     */
    public function setEnglishDescription($englishDescription)
    {
        $this->englishDescription = $englishDescription;

        return $this;
    }

    /**
     * Get englishDescription
     *
     * @return string 
     */
    public function getEnglishDescription()
    {
        return $this->englishDescription;
    }

    /**
     * Set likeCount
     *
     * @param string $likeCount
     * @return Event
     */
    public function setLikeCount($likeCount)
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    /**
     * Get likeCount
     *
     * @return string 
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
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
