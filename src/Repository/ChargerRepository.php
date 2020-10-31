<?php

namespace App\Repository;

use App\Entity\Charger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

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

    public function findChargersByQuery(string $query)
    {
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->select('c')
            ->where($qb->expr()->like('c.name', ':query'))
            ->orWhere($qb->expr()->like('c.addressLine', ':query'))
            ->orWhere($qb->expr()->like('c.town', ':query'))
            ->orWhere($qb->expr()->like('c.stateOrProvince', ':query'))
            ->setParameter('query', "%${query}%")
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }
}
