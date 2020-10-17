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
}
