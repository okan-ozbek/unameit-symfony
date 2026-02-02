<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function save(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function fetchAll(): array
    {
        return $this->createQueryBuilder('task')
            ->orderBy('task.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function fetchById(int $id): ?Task
    {
        return $this->createQueryBuilder('task')
            ->andWhere('task.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByStatus(string $status): array
    {
        return $this->createQueryBuilder('task')
            ->andWhere('task.status = :status')
            ->setParameter('status', $status)
            ->orderBy('task.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
