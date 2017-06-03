<?php

namespace SayHiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserGroups
 *
 * @ORM\Table(name="UserGroups")
 * @ORM\Entity(repositoryClass="SayHiBundle\Repository\UserGroupsRepository")
 */
class UserGroups
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
     * @ORM\Column(name="group_name", type="string", length=50)
     */
    private $groupName;
    
    /**
    * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
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
     * Set groupName
     *
     * @param string $groupName
     * @return UserGroups
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get groupName
     *
     * @return string 
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Add users
     *
     * @param \SayHiBundle\Entity\User $users
     * @return UserGroups
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
