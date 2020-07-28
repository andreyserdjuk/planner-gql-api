<?php

namespace Planner\TaskORMBundle\Entity;

use Planner\TaskCoreBundle\Core\Model\TaskPropertyInterface;
use Planner\TaskORMBundle\Repository\TaskPropertyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskPropertyRepository::class)
 */
class TaskProperty implements TaskPropertyInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $type;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="taskProperties")
     * @ORM\JoinColumn(nullable=false)
     */
    private Task $task;

    /**
     * @ORM\Column(type="string", length=2056)
     */
    private string $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): TaskProperty
    {
        $this->content = $content;
        return $this;
    }
}
