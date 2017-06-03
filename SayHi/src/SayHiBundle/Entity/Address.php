<?php

namespace SayHiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Address
 *
 * @ORM\Table(name="Addresses")
 * @ORM\Entity(repositoryClass="SayHiBundle\Repository\AddressRepository")
 */
class Address
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
     * @ORM\Column(name="city", type="string", length=50)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=50)
     */
    private $street;

    /**
     * @var int
     *
     * @ORM\Column(name="street_nr", type="integer")
     */
    private $streetNr;

    /**
     * @var int
     *
     * @ORM\Column(name="apt_nr", type="integer", nullable=true)
     */
    private $aptNr;
    
    /**
    * @ORM\OneToMany(targetEntity="User", mappedBy="address")
    */
    private $users;
    public function __construct() {
    $this->users = new ArrayCollection();
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
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set streetNr
     *
     * @param integer $streetNr
     * @return Address
     */
    public function setStreetNr($streetNr)
    {
        $this->streetNr = $streetNr;

        return $this;
    }

    /**
     * Get streetNr
     *
     * @return integer 
     */
    public function getStreetNr()
    {
        return $this->streetNr;
    }

    /**
     * Set aptNr
     *
     * @param integer $aptNr
     * @return Address
     */
    public function setAptNr($aptNr)
    {
        $this->aptNr = $aptNr;

        return $this;
    }

    /**
     * Get aptNr
     *
     * @return integer 
     */
    public function getAptNr()
    {
        return $this->aptNr;
    }

    /**
     * Add users
     *
     * @param \SayHiBundle\Entity\User $users
     * @return Address
     */
    public function addUser(\SayHiBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \SayHiBundle\Entity\User $users
     */
    public function removeUser(\SayHiBundle\Entity\User $users)
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
}
