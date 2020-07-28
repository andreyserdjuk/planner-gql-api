<?php

namespace Planner\TaskORMBundle\Entity;

use Planner\TaskCoreBundle\Core\Model\TaskStatusInterface;
use Planner\TaskORMBundle\Repository\TaskStatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskStatusRepository::class)
 */
class TaskStatus implements TaskStatusInterface
{
    const SCHEDULED = 'scheduled';
    const DONE = 'done';

    /**
     * @ORM\Column(name="`name`", type="string", length=32, unique=true)
     * @ORM\Id
     */
    protected string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $label;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): TaskStatus
    {
        $this->label = $label;
        return $this;
    }
}
