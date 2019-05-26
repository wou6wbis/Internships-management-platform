<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;

/**
 * Tâche
 * @ApiResource(
 *     collectionOperations={
 *         "get",
 *         "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "delete"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 * @ORM\Table(name="todos")
 * @ORM\Entity()
 *
 */
class Todo {
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="tid", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string Description de la tâche
     *
     * La description plutôt complète de la tâche
     *
     * @ORM\Column(name="title", type="text", nullable=True)
     */
    private $title = "";
    
    /**
     * @var bool Is the task completed/finished.
     * 
     *  If a todo task is completed, true. If it's still active, false
     *    
     * @ORM\Column(type="boolean")
     */
    private $completed;

    /**
     * @var \Datetime Date of creation
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
    
    /**
     * @var \Datetime Date of last modification
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="todos")
     */
    private $project;
    
    public function __construct() 
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }
    
    /**
     * @return string
     */
    public function __toString() 
    {
        $s = '';
        $s .= $this->getId() .' '. $this->getTitle() .' ';
        $s .= $this->getCompleted() ? '(completed)': '(not complete)';
        return $s;
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    public function setTitle(string $title): self
    {
        $this->title = $title;
        
        return $this;
    }
    
    public function getCompleted(): ?bool
    {
        return $this->completed;
    }
    
    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;
        
        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return \Datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param \Datetime $created
     */
    public function setCreated(Datetime $created)
    {
        $this->created = $created;
    }

    /**
     * @param \Datetime $updated
     */
    public function setUpdated(Datetime $updated)
    {
        $this->updated = $updated;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

}