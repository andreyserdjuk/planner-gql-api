<?php

namespace Planner\TaskORMBundle\Repository;

use Planner\TaskCoreBundle\Core\Repository\TaskStatusRepositoryInterface;
use Planner\TaskORMBundle\Entity\TaskStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskStatus[]    findAll()
 * @method TaskStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskStatusRepository extends ServiceEntityRepository implements TaskStatusRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskStatus::class);
    }
}
