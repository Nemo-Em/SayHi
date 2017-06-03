<?php

namespace SayHiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 *
 * @ORM\Table(name="Phones")
 * @ORM\Entity(repositoryClass="SayHiBundle\Repository\PhoneRepository")
 */
class Phone
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
     * @ORM\Column(name="number", type="string", length=50, nullable=true)
     */
    private $number;
    
    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="phones")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;
    
    /**
    * @ORM\ManyToOne(targetEntity="ContactType", inversedBy="phones")
    * @ORM\JoinColumn(name="contact_type", referencedColumnName="id")
    */
    private $contactType;


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
     * Set number
     *
     * @param string $number
     * @return Phone
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set user
     *
     * @param \SayHiBundle\Entity\User $user
     * @return Phone
     */
    public function setUser(\SayHiBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SayHiBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set contactType
     *
     * @param \SayHiBundle\Entity\ContactType $contactType
     * @return Phone
     */
    public function setContactType(\SayHiBundle\Entity\ContactType $contactType = null)
    {
        $this->contactType = $contactType;

        return $this;
    }

    /**
     * Get contactType
     *
     * @return \SayHiBundle\Entity\ContactType 
     */
    public function getContactType()
    {
        return $this->contactType;
    }
}
