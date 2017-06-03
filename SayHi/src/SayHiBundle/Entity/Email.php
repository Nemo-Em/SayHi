<?php

namespace SayHiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="Emails")
 * @ORM\Entity(repositoryClass="SayHiBundle\Repository\EmailRepository")
 */
class Email
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
     * @ORM\Column(name="email_address", type="string", length=50, nullable=true)
     */
    private $emailAddress;
    
    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="emails")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;
    
    /**
    * @ORM\ManyToOne(targetEntity="ContactType", inversedBy="emails")
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
     * Set address
     *
     * @param string $address
     * @return Email
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     * @return Email
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string 
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set user
     *
     * @param \SayHiBundle\Entity\User $user
     * @return Email
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
     * @return Email
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
