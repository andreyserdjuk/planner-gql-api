<?php

namespace App\Entity;

use App\Core\Model\TaskInterface;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task implements TaskInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected string $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected ?\DateTime $dateStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected ?\DateTime $dateEnd;

    /**
     * @ORM\OneToMany(targetEntity=TaskProperty::class, mappedBy="task", orphanRemoval=true)
     */
    protected Collection $taskProperties;

    /**
     * @ORM\ManyToOne(targetEntity="TaskPriority")
     * @ORM\JoinColumn(name="task_priority_name", referencedColumnName="`name`", onDelete="SET NULL")
     */
    protected TaskPriority $taskPriority;

    /**
     * @ORM\ManyToOne(targetEntity="TaskStatus")
     * @ORM\JoinColumn(name="task_status_name", referencedColumnName="`name`", onDelete="SET NULL")
     */
    protected TaskStatus $taskStatus;

    public function __construct()
    {
        $this->taskProperties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Task
    {
        $this->title = $title;
        return $this;
    }

    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(?\DateTime $dateStart): Task
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTime $dateEnd): Task
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * @return Collection|TaskProperty[]
     */
    public function getTaskProperties(): Collection
    {
        return $this->taskProperties;
    }

    public function addTaskProperty(TaskProperty $taskProperty): self
    {
        if (!$this->taskProperties->contains($taskProperty)) {
            $this->taskProperties[] = $taskProperty;
            $taskProperty->setTask($this);
        }

        return $this;
    }

    public function removeTaskProperty(TaskProperty $taskProperty): self
    {
        if ($this->taskProperties->contains($taskProperty)) {
            $this->taskProperties->removeElement($taskProperty);
            // set the owning side to null (unless already changed)
            if ($taskProperty->getTask() === $this) {
                $taskProperty->setTask(null);
            }
        }

        return $this;
    }

    public function getTaskPriority(): TaskPriority
    {
        return $this->taskPriority;
    }

    public function setTaskPriority(TaskPriority $taskPriority): Task
    {
        $this->taskPriority = $taskPriority;
        return $this;
    }

    public function getTaskStatus(): TaskStatus
    {
        return $this->taskStatus;
    }

    public function setTaskStatus(TaskStatus $taskStatus): Task
    {
        $this->taskStatus = $taskStatus;
        return $this;
    }
}
