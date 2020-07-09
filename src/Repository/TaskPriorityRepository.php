<?php

namespace App\Repository;

use App\Core\Repository\TaskPriorityRepositoryInterface;
use App\Entity\TaskPriority;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskPriority|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskPriority|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskPriority[]    findAll()
 * @method TaskPriority[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskPriorityRepository extends ServiceEntityRepository implements TaskPriorityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskPriority::class);
    }
}
