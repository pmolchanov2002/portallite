<?php

// src/AppBundle/Entity/Article.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Article")
 */
class Article
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
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $description;
    

    /**
     * @ORM\Column(name="Content", type="blob")
     * @Assert\NotBlank()
     */
    protected $content;
    
    /**
     * @ORM\Column(name="Created", type="datetime")
     */
    protected $created;
    
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
     * @ORM\ManyToOne(targetEntity="ArticleType")
     * @ORM\JoinColumn(name="TypeId", referencedColumnName="id")
     **/
    protected $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="AuthorId", referencedColumnName="id")
     **/
    protected $author;
        
    
//     /**
//      * @ORM\ManyToOne(targetEntity="User")
//      * @ORM\JoinColumn(name="User", referencedColumnName="id")
//      **/
//     protected $author;
    
    /**
     * @ORM\ManyToMany(targetEntity="Media")
     * @ORM\JoinTable(name="Article_Image",
     *      joinColumns={@ORM\JoinColumn(name="ArticleId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="MediaId", referencedColumnName="id")}
     *      )
     **/
    protected $images;
    
    /**
     * @ORM\ManyToMany(targetEntity="Media")
     * @ORM\JoinTable(name="Article_Document",
     *      joinColumns={@ORM\JoinColumn(name="ArticleId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="MediaId", referencedColumnName="id")}
     *      )
     **/
    protected $documents;
    
    /**
     * @ORM\ManyToMany(targetEntity="Page")
     * @ORM\JoinTable(name="Page_Article",
     *      joinColumns={@ORM\JoinColumn(name="ArticleId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="PageId", referencedColumnName="id")}
     *      )
     **/
    protected $pages;
    
    /**
     * @ORM\ManyToOne(targetEntity="Media")
     * @ORM\JoinColumn(name="IconId", referencedColumnName="id")
     **/
    protected $icon;
    
    /**
     * @ORM\ManyToMany(targetEntity="Media")
     * @ORM\JoinTable(name="Article_Video",
     *      joinColumns={@ORM\JoinColumn(name="ArticleId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="MediaId", referencedColumnName="id")}
     *      )
     **/
    protected $videos;
    
    /**
     * @ORM\ManyToMany(targetEntity="Media")
     * @ORM\JoinTable(name="Article_Audio",
     *      joinColumns={@ORM\JoinColumn(name="ArticleId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="MediaId", referencedColumnName="id")}
     *      )
     **/
    protected $audios;    
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Article
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
     * Set description
     *
     * @param string $description
     * @return Article
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
     * Set content
     *
     * @param string $content
     * @return Article
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
     * @return Article
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
     * Set language
     *
     * @param \AppBundle\Entity\Language $language
     * @return Article
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
     * @return Article
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
     * Set type
     *
     * @param \AppBundle\Entity\ArticleType $type
     * @return Article
     */
    public function setType(\AppBundle\Entity\ArticleType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\ArticleType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     * @return Article
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add images
     *
     * @param \AppBundle\Entity\Media $images
     * @return Article
     */
    public function addImage(\AppBundle\Entity\Media $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \AppBundle\Entity\Media $images
     */
    public function removeImage(\AppBundle\Entity\Media $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add pages
     *
     * @param \AppBundle\Entity\Page $pages
     * @return Article
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

    /**
     * Add documents
     *
     * @param \AppBundle\Entity\Media $documents
     * @return Article
     */
    public function addDocument(\AppBundle\Entity\Media $documents)
    {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \AppBundle\Entity\Media $documents
     */
    public function removeDocument(\AppBundle\Entity\Media $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set icon
     *
     * @param \AppBundle\Entity\Media $icon
     * @return Article
     */
    public function setIcon(\AppBundle\Entity\Media $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return \AppBundle\Entity\Media 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Add videos
     *
     * @param \AppBundle\Entity\Media $videos
     * @return Article
     */
    public function addVideo(\AppBundle\Entity\Media $videos)
    {
        $this->videos[] = $videos;

        return $this;
    }

    /**
     * Remove videos
     *
     * @param \AppBundle\Entity\Media $videos
     */
    public function removeVideo(\AppBundle\Entity\Media $videos)
    {
        $this->videos->removeElement($videos);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Add audios
     *
     * @param \AppBundle\Entity\Media $audios
     * @return Article
     */
    public function addAudio(\AppBundle\Entity\Media $audios)
    {
        $this->audios[] = $audios;

        return $this;
    }

    /**
     * Remove audios
     *
     * @param \AppBundle\Entity\Media $audios
     */
    public function removeAudio(\AppBundle\Entity\Media $audios)
    {
        $this->audios->removeElement($audios);
    }

    /**
     * Get audios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAudios()
    {
        return $this->audios;
    }
}
