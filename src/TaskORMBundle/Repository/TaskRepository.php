<?php

namespace Planner\TaskORMBundle\Repository;

use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Planner\TaskCoreBundle\Core\Repository\TaskRepositoryInterface;
use Planner\TaskORMBundle\Entity\Task;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function getPagedByCriteria(
        array $filters,
        array $sortings,
        int $limit,
        int $offset
    ): array {
        $qb = $this->createQueryBuilder('task')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $metadata = $this->getClassMetadata();

        foreach ($filters as [$propertyName, $condition, $value]) {
            if ($metadata->hasField($propertyName)) {
                if ('datetime' === $metadata->getFieldMapping($propertyName)) {
                    $dateTimes = [];
                    foreach ($value as $index => $val) {
                        $val = DateTime::createFromFormat(DateTime::ISO8601, $val);
                        if ($val instanceof DateTime) {
                            $dateTimes[] = $val;
                        }
                    }
                    $value = $dateTimes;
                }
            } elseif (!$metadata->hasAssociation($propertyName)) {
                continue;
            }

            if (1 === count($value)) {
                $qb->andWhere(
                    $qb
                        ->expr()
                        ->$condition('task.'.$propertyName, ':'.$propertyName)
                )
                    ->setParameter($propertyName, $value[0]);
            } elseif (2 === count($value)) {
                $qb->andWhere(
                    $qb
                        ->expr()
                        ->between('task.'.$propertyName, ':from'.$propertyName, ':to'.$propertyName)
                )
                    ->setParameter('from'.$propertyName, $value[0])
                    ->setParameter('to'.$propertyName, $value[1]);
            }
        }

        foreach ($sortings as [$propertyName, $sorting]) {
            $qb->addOrderBy('task.'.$propertyName, $sorting);
        }

        return $qb->getQuery()->getResult();
    }
}
