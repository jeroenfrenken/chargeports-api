<?php

namespace App\Repository;

use App\Entity\Reservation;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @param DateTime $dateTime
     * @param UserInterface $user
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findAfterTime(DateTime $dateTime, UserInterface $user)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.startTime > :startTime')
            ->andWhere('r.user = :user')
            ->setParameter('startTime', $dateTime)
            ->setParameter('user', $user)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param DateTime $dateTime
     * @param UserInterface $user
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findBeforeTime(DateTime $dateTime, UserInterface $user)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.endTime < :endTime')
            ->andWhere('r.user = :user')
            ->setParameter('endTime', $dateTime)
            ->setParameter('user', $user)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }
}
