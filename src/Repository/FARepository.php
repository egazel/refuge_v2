<?php

namespace App\Repository;

use App\Entity\FA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FA|null find($id, $lockMode = null, $lockVersion = null)
 * @method FA|null findOneBy(array $criteria, array $orderBy = null)
 * @method FA[]    findAll()
 * @method FA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FA::class);
    }

    // /**
    //  * @return FA[] Returns an array of FA objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FA
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
