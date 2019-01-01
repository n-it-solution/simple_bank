<?php

namespace App\Repository;

use App\Entity\Direct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Direct|null find($id, $lockMode = null, $lockVersion = null)
 * @method Direct|null findOneBy(array $criteria, array $orderBy = null)
 * @method Direct[]    findAll()
 * @method Direct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Direct::class);
    }

    // /**
    //  * @return Direct[] Returns an array of Direct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Direct
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
