<?php

namespace App\Repository;

use App\Entity\Charger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Charger|null find($id, $lockMode = null, $lockVersion = null)
 * @method Charger|null findOneBy(array $criteria, array $orderBy = null)
 * @method Charger[]    findAll()
 * @method Charger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChargerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Charger::class);
    }

    public function findChargers()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Charger
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
