<?php

// src/AppBundle/Entity/Language.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Language")
 */
class Language
{
	 /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    protected $code;

     /**
     * @ORM\Column(unique=true)
     * @Assert\NotBlank()
     */
    protected $name;
   
    /**
     * @ORM\Column(unique=true, name="NativeName")
     * @Assert\NotBlank()
     */
    protected $nativeName;

    /**
     * Set code
     *
     * @param string $code
     * @return Language
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Language
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
     * Set nativeName
     *
     * @param string $nativeName
     * @return Language
     */
    public function setNativeName($nativeName)
    {
        $this->nativeName = $nativeName;

        return $this;
    }

    /**
     * Get nativeName
     *
     * @return string 
     */
    public function getNativeName()
    {
        return $this->nativeName;
    }
}
