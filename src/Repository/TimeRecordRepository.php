<?php

namespace App\Repository;

use App\Entity\TimeRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TimeRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeRecord[]    findAll()
 * @method TimeRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeRecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeRecord::class);
    }

    // /**
    //  * @return TimeRecord[] Returns an array of TimeRecord objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TimeRecord
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
