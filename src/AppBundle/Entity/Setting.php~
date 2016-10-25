<?php

// src/AppBundle/Entity/Page.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Setting")
 */
class Setting
{
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(name="Value")
     */
    protected $value;
    
    /**
     * @ORM\ManyToOne(targetEntity="SettingType")
     * @ORM\JoinColumn(name="SettingTypeId", referencedColumnName="id")
     **/
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="LanguageId", referencedColumnName="code")
     **/
    protected $language;
    

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
     * Set value
     *
     * @param string $value
     * @return Setting
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\SettingType $type
     * @return Setting
     */
    public function setType(\AppBundle\Entity\SettingType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\SettingType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set language
     *
     * @param \AppBundle\Entity\Language $language
     * @return Setting
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
}
