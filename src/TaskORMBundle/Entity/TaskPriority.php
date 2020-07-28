<?php

namespace Planner\TaskORMBundle\Entity;

use Planner\TaskCoreBundle\Core\Model\TaskPriorityInterface;
use Planner\TaskORMBundle\Repository\TaskPriorityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskPriorityRepository::class)
 */
class TaskPriority implements TaskPriorityInterface
{
    /**
     * @ORM\Column(name="`name`", type="string", length=32, unique=true)
     * @ORM\Id
     */
    protected string $name;

    /**
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected string $label;

    /**
     * @ORM\Column(name="`order`", type="integer")
     */
    protected int $order;

    public function setName(string $name): TaskPriority
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): TaskPriority
    {
        $this->label = $label;
        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): TaskPriority
    {
        $this->order = $order;
        return $this;
    }
}
