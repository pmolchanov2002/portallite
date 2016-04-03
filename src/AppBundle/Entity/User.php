<?php

// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User implements UserInterface, \Serializable
{
       
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank()
     */
    protected $username;

     /**
     * @ORM\Column(type="string", length=100)
     */
    protected $password;

     /**
     * @ORM\Column(name="firstName", type="string", length=50)
     * @Assert\NotBlank()
     */
    protected $firstName;

     /**
     * @ORM\Column(name="lastName", type="string", length=50)
     * @Assert\NotBlank()
     */
    protected $lastName;
    
    /**
     * @ORM\Column(name="EnglishName", unique=true)
     * @Assert\NotBlank()
     */
    protected $englishName;

    public function __toString() {
        return $this->lastName.' '.$this->firstName;
    }
    
    public function eraseCredentials()
    {
    }
    
    public function getSalt()
    {
    	// you *may* need a real salt depending on your encoder
    	// see section on salt below
    	return null;
    }
    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
    	return serialize(array(
    			$this->id,
    			$this->username,
    			$this->password
    	));
    }
    
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
    	list (
    			$this->id,
    			$this->username,
    			$this->password
    			) = unserialize($serialized);
    }
    
    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="User_Role",
     *      joinColumns={@ORM\JoinColumn(name="userId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="roleId", referencedColumnName="id")}
     *      )
     **/
    protected $roles;


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
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add roles
     *
     * @param \AppBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\AppBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \AppBundle\Entity\Role $roles
     */
    public function removeRole(\AppBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles->toArray();;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set englishName
     *
     * @param string $englishName
     * @return User
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
}
