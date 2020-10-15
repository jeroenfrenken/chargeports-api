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
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT
            id,
            name,
            is_available,
            latitude,
            longitude,
            uuid,
            (
              6371 * acos (
              cos ( radians(:lat) )
              * cos( radians( latitude ) )
              * cos( radians( longitude ) - radians(:long) )
              + sin ( radians(:lat) )
              * sin( radians( latitude ) )
            )
        ) AS distance
        FROM charger
        HAVING distance < 10
        ORDER BY distance
        LIMIT 75;";

        $stmt = $conn->prepare($sql);
        $stmt->execute(
            [
                'lat' => $lat,
                'long' => $long
            ]
        );

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
