<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

//     /**
//      * @return Transaction[] Returns an array of Transaction objects
//     */

    public function findByReceiver($id,$currency)
    {
        return $this->createQueryBuilder('t')
            ->select('sum(t.Amount)')
            ->andWhere('t.Receiver = :val')
            ->andWhere('t.Currency = :currency')
            ->andWhere('t.Type <= :type')
            ->setParameters(['val' => $id, 'currency' => $currency, 'type' => 2])
            ->getQuery()
            ->getResult()
        ;
    }
//    /**
//      * @return Transaction[] Returns an array of Transaction objects
//     */

    public function findByid($id)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :val')
            ->setParameter('val' , $id)
            ->getQuery()
            ->getResult()
        ;
    }
//    /**
//     * @return Transaction[] Returns an array of Transaction objects
//     */
    public function findBySender($id,$currency)
    {
        return $this->createQueryBuilder('t')
            ->select('sum(t.Amount)')
            ->andWhere('t.Sender = :val')
            ->andWhere('t.Currency = :currency')
            ->andWhere('t.Type <= :type')
            ->setParameters(['val' => $id, 'currency' => $currency, 'type' => 2])
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Transaction
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
