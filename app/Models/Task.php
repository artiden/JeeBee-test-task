<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\TaskRepository")
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="user_name", type="string")
     * @var string
     */
    private $userName;

    /**
     * @ORM\Column(name="user_email", type="string")
     * @var string
     */
    private $userEmail;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $image;

    /**
     * @ORM\Column(name="is_done", type="boolean", options={"default":false})
     * @var boolean
     */
    private $isDone = 0;

    /**
     * @ORM\Column(name="created_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Get an id of persist entity
     * 
     * @return int
     */
    public function getID():int
    {
        return $this->id;
    }

    /**
     * Get a description of the persist entity
     * 
     * @return string
     */
    public function getDescription():string
    {
        return $this->description;
    }

    /**
     * Set a description of the entity
     * 
     * @param string $description
     */
    public function setDescription(string $description):void
    {
        $this->description = $description;
    }

    /**
     * Set user name
     * 
     * @param string $userName
     */
    public function setUserName(string $userName):void
    {
        $this->userName = $userName;
    }

    /**
     * Get user name
     * 
     * @return string|NULL
     */
    public function getUserName():?string
    {
        return $this->userName;
    }

    /**
     * Set user email
     * 
     * @param string $email
     */
    public function setUserEmail(string $email):void
    {
        $this->userEmail = $email;
    }

    /**
     * Get user email
     * 
     * @return string|NULL
     */
    public function getUserEmail():?string
    {
        return $this->userEmail;
    }

    /**
     * Set image
     * 
     * @param string $path
     */
    public function setImage(string $path):void
    {
        $this->image = $path;
    }

    /**
     * Get a path to the task image
     * 
     * @return string|NULL
     */
    public function getImage():?string
    {
        return $this->image;
    }

    /**
     * Set done status of the task
     * 
     * @param bool $done
     */
    public function setDone(bool $done):void
    {
        $this->isDone = $done;
    }

    /**
     * Get done status of the task
     * 
     * @return bool
     */
    public function IsDone():bool
    {
        return boolval($this->isDone);
    }

    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get date and time when entity wass created
     * 
     * @return \DateTime
     */
    public function getCreatedAt():?\DateTime
    {
        return $this->createdAt;
    }
}
