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

    /**
     * @param Task $user
     * @param bool $flush
     * @return void
     */
    public function save(Task $user, bool $flush = false): void
    {
        $this->getEntityManager()->persist($user);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->createQueryBuilder('task')
            ->delete()
            ->where('task.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array|null
     */
    public function findByCriteria(array $criteria = [], array $orderBy = [], int $limit = null, int $offset = null): ?array
    {
        $qb = $this->createQueryBuilder('task');

        foreach ($criteria as $field => $value) {
            $qb->andWhere($qb->expr()->eq('task.'.$field, ':'.$field));
        }

        foreach ($orderBy as $field => $order) {
            $qb->addOrderBy('task.'.$field, $order);
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        if ($offset) {
            $qb->setFirstResult($offset);
        }

        $totalCount = $this
            ->createQueryBuilder('task')
            ->select('count(task.id)')
            ->getQuery()
            ->getSingleScalarResult();


        return [
            'totalCount' => $totalCount,
            'list' => $qb->getQuery()->getResult()
        ];
    }
}
