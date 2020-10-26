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
            ->setMaxResults(75)
            ->getQuery()
            ->getResult();
    }

    public function findChargersByLatLong(string $lat, string $long)
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->addSelect("(
              6371 * acos (
              cos ( radians(:lat) )
              * cos( radians( c.latitude ) )
              * cos( radians( c.longitude ) - radians(:long) )
              + sin ( radians(:lat) )
              * sin( radians( c.latitude ) )
              )
              ) AS distance")
            ->setParameter("lat", $lat)
            ->setParameter("long", $long)
            ->orderBy("distance", "ASC")
            ->setMaxResults(25)
            ->getQuery()
            ->getResult('ChargerHydration');
    }
}
