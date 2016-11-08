<?php

// src/AppBundle/Entity/Page.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Page")
 */
class Page
{
	 /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    protected $id;

     /**
     * @ORM\Column(unique=true)
     * @Assert\NotBlank()
     */
    protected $title;
    
    /**
     * @ORM\Column(name="SubTitle")
     */
    protected $subTitle;
    
    /**
     * @ORM\ManyToOne(targetEntity="PageType")
     * @ORM\JoinColumn(name="PageTypeId", referencedColumnName="id")
     * 
     * @ORM\OrderBy({"name" = "ASC"})
     **/
    protected $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Banner", inversedBy="pages")
     * @ORM\JoinColumn(name="BannerId", referencedColumnName="id")
     **/
    protected $banner;
    
    /**
     * @ORM\ManyToMany(targetEntity="Article")
     * @ORM\JoinTable(name="Page_Article",
     *      joinColumns={@ORM\JoinColumn(name="PageId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ArticleId", referencedColumnName="id")}
     *      )
     * @ORM\OrderBy({"created" = "DESC"})
     **/
    protected $articles;
    
    /**
     * @ORM\ManyToMany(targetEntity="Faq")
     * @ORM\JoinTable(name="Page_Faq",
     *      joinColumns={@ORM\JoinColumn(name="PageId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="FaqId", referencedColumnName="id")}
     *      )
     * @ORM\OrderBy({"ordinal" = "ASC"})
     **/
    protected $faqs;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="Lang", referencedColumnName="code")
     **/
    protected $language;
    
    /**
     * @ORM\Column(name="ArticlesPerPage")
     * @Assert\NotBlank()
     */
    protected $articlesPerPage;
    
    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="Page_User",
     *      joinColumns={@ORM\JoinColumn(name="PageId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="UserId", referencedColumnName="id")}
     *      )
     **/
    protected $users;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->banners = new \Doctrine\Common\Collections\ArrayCollection();
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function clearArticles() {
    	$this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Page
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
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
     * Set subTitle
     *
     * @param string $subTitle
     * @return Page
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * Get subTitle
     *
     * @return string 
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\PageType $type
     * @return Page
     */
    public function setType(\AppBundle\Entity\PageType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\PageType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add articles
     *
     * @param \AppBundle\Entity\Article $articles
     * @return Page
     */
    public function addArticle(\AppBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \AppBundle\Entity\Article $articles
     */
    public function removeArticle(\AppBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set language
     *
     * @param \AppBundle\Entity\Language $language
     * @return Page
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
     * Set articlesPerPage
     *
     * @param string $articlesPerPage
     * @return Page
     */
    public function setArticlesPerPage($articlesPerPage)
    {
        $this->articlesPerPage = $articlesPerPage;

        return $this;
    }

    /**
     * Get articlesPerPage
     *
     * @return string 
     */
    public function getArticlesPerPage()
    {
        return $this->articlesPerPage;
    }

    /**
     * Set banner
     *
     * @param \AppBundle\Entity\Banner $banner
     * @return Page
     */
    public function setBanner(\AppBundle\Entity\Banner $banner = null)
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
     * Add users
     *
     * @param \AppBundle\Entity\User $users
     * @return Page
     */
    public function addUser(\AppBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \AppBundle\Entity\User $users
     */
    public function removeUser(\AppBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add faqs
     *
     * @param \AppBundle\Entity\Faq $faqs
     * @return Page
     */
    public function addFaq(\AppBundle\Entity\Faq $faqs)
    {
        $this->faqs[] = $faqs;

        return $this;
    }

    /**
     * Remove faqs
     *
     * @param \AppBundle\Entity\Faq $faqs
     */
    public function removeFaq(\AppBundle\Entity\Faq $faqs)
    {
        $this->faqs->removeElement($faqs);
    }

    /**
     * Get faqs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFaqs()
    {
        return $this->faqs;
    }
}
