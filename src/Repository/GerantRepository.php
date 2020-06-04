<?php

namespace App\Repository;

use App\Entity\Gerant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gerant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gerant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gerant[]    findAll()
 * @method Gerant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GerantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gerant::class);
    }

    // /**
    //  * @return Gerant[] Returns an array of Gerant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gerant
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
