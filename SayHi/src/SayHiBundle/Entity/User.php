<?php

namespace SayHiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="Users")
 * @ORM\Entity(repositoryClass="SayHiBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=50)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
    * @ORM\ManyToOne(targetEntity="Address", inversedBy="users")
    * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
    */
    private $address;
    
    /**
    * @ORM\OneToMany(targetEntity="Phone", mappedBy="user")
    */
    private $phones;
    
    /**
    * @ORM\OneToMany(targetEntity="Email", mappedBy="user")
    */
    private $emails;
    
    /**
    * @ORM\ManyToMany(targetEntity="UserGroups", inversedBy="users")
    * @ORM\JoinTable(name="users_groups")
    */
    private $groups;
    public function __construct() {
    $this->emails = new ArrayCollection();
    $this->phones = new ArrayCollection();
    $this->groups = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
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
     * Set address
     *
     * @param \SayHiBundle\Entity\Address $address
     * @return User
     */
    public function setAddress(\SayHiBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \SayHiBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add phones
     *
     * @param \SayHiBundle\Entity\Phone $phones
     * @return User
     */
    public function addPhone(\SayHiBundle\Entity\Phone $phones)
    {
        $this->phones[] = $phones;

        return $this;
    }

    /**
     * Remove phones
     *
     * @param \SayHiBundle\Entity\Phone $phones
     */
    public function removePhone(\SayHiBundle\Entity\Phone $phones)
    {
        $this->phones->removeElement($phones);
    }

    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Add emails
     *
     * @param \SayHiBundle\Entity\Email $emails
     * @return User
     */
    public function addEmail(\SayHiBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param \SayHiBundle\Entity\Email $emails
     */
    public function removeEmail(\SayHiBundle\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add groups
     *
     * @param \SayHiBundle\Entity\UserGroups $groups
     * @return User
     */
    public function addGroup(\SayHiBundle\Entity\UserGroups $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \SayHiBundle\Entity\UserGroups $groups
     */
    public function removeGroup(\SayHiBundle\Entity\UserGroups $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
