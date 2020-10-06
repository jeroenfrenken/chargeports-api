<?php

namespace App\Repository;

use App\Entity\ChargerConnection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChargerConnection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChargerConnection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChargerConnection[]    findAll()
 * @method ChargerConnection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChargerConnectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChargerConnection::class);
    }

    // /**
    //  * @return ChargerConnection[] Returns an array of ChargerConnection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChargerConnection
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
