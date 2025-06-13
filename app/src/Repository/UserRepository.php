<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function existByEmail(string $email): bool
    {
        return !$this->findOneBy(['email' => $email]);
    }

    /**
     * @param User $user
     * @param bool $flush
     * @return void
     */
    public function save(User $user, bool $flush = false): void
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
        $this->createQueryBuilder('user')
            ->delete()
            ->where('user.id = :id')
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
        $qb = $this->createQueryBuilder('user');

        foreach ($criteria as $field => $value) {
            $qb->andWhere($qb->expr()->eq('user.'.$field, ':'.$field));
        }

        foreach ($orderBy as $field => $order) {
            $qb->addOrderBy('user.'.$field, $order);
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        if ($offset) {
            $qb->setFirstResult($offset);
        }

        $totalCount = $this
            ->createQueryBuilder('user')
            ->select('count(user.id)')
            ->getQuery()
            ->getSingleScalarResult();


        return [
            'totalCount' => $totalCount,
            'list' => $qb->getQuery()->getResult(),
            'limit' => $limit,
            'offset' => $offset,
        ];
    }
}
