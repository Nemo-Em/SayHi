<?php

namespace SayHiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactType
 *
 * @ORM\Table(name="ContactTypes")
 * @ORM\Entity(repositoryClass="SayHiBundle\Repository\ContactTypeRepository")
 */
class ContactType
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
     * @ORM\Column(name="description", type="string", length=50)
     */
    private $description;
    
    /**
    * @ORM\OneToMany(targetEntity="Phone", mappedBy="contactType")
    */
    private $phones;
    
    /**
    * @ORM\OneToMany(targetEntity="Email", mappedBy="contactType")
    */
    private $emails;

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
     * Set description
     *
     * @param string $description
     * @return ContactType
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
     * Set email
     *
     * @param \SayHiBundle\Entity\Email $email
     * @return ContactType
     */
    public function setEmail(\SayHiBundle\Entity\Email $email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return \SayHiBundle\Entity\Email 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param \SayHiBundle\Entity\Phone $phone
     * @return ContactType
     */
    public function setPhone(\SayHiBundle\Entity\Phone $phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return \SayHiBundle\Entity\Phone 
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add phones
     *
     * @param \SayHiBundle\Entity\Phone $phones
     * @return ContactType
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
     * @return ContactType
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
}
