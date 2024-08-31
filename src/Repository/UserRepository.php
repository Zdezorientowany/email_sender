<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param array $categories
     * @return User[]
     */
    public function findByCategories(array $categories): array
    {
        $qb = $this->createQueryBuilder('u')
            ->innerJoin('u.categories', 'c')
            ->where('c.name IN (:categories)')
            ->setParameter('categories', $categories);

        return $qb->getQuery()->getResult();
    }
}
