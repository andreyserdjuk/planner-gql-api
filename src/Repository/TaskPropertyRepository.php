<?php

namespace App\Repository;

use App\Core\Repository\TaskPropertyRepositoryInterface;
use App\Entity\TaskProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskProperty[]    findAll()
 * @method TaskProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskPropertyRepository extends ServiceEntityRepository implements TaskPropertyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskProperty::class);
    }
}
