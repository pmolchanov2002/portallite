<?php

// src/AppBundle/Entity/Menu.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Menu")
 */
class Menu
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
    protected $title;
    
    /**
     * @ORM\Column(unique=true, name="SubTitle")
     * @Assert\NotBlank()
     */
    protected $subTitle;
    
    /** 
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="children")
     * @ORM\JoinColumn(name="parentMenuId", referencedColumnName="id")
     **/
    protected $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent")
     * @ORM\JoinColumn(name="ParentMenuId", referencedColumnName="id")
     * @ORM\OrderBy({"sortOrder" = "ASC"})
     **/
    protected $children;
    
    /**
     * @ORM\ManyToOne(targetEntity="MenuType")
     * @ORM\JoinColumn(name="MenuTypeId", referencedColumnName="id")
     **/
    protected $menuType;
    
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
     * @ORM\Column(name="Url")
     */
    protected $url;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Menu
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
     * @return Menu
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
     * Set parent
     *
     * @param \AppBundle\Entity\Menu $parent
     * @return Menu
     */
    public function setParent(\AppBundle\Entity\Menu $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Menu 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \AppBundle\Entity\Menu $children
     * @return Menu
     */
    public function addChild(\AppBundle\Entity\Menu $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \AppBundle\Entity\Menu $children
     */
    public function removeChild(\AppBundle\Entity\Menu $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set menuType
     *
     * @param \AppBundle\Entity\MenuType $menuType
     * @return Menu
     */
    public function setMenuType(\AppBundle\Entity\MenuType $menuType = null)
    {
        $this->menuType = $menuType;

        return $this;
    }

    /**
     * Get menuType
     *
     * @return \AppBundle\Entity\MenuType 
     */
    public function getMenuType()
    {
        return $this->menuType;
    }

    /**
     * Set language
     *
     * @param \AppBundle\Entity\Language $language
     * @return Menu
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
     * @return Menu
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
     * Set sortOrder
     *
     * @param string $sortOrder
     * @return Menu
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
     * Set page
     *
     * @param \AppBundle\Entity\Page $page
     * @return Menu
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
     * Set url
     *
     * @param string $url
     * @return Menu
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
