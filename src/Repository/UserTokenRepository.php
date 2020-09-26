<?php

namespace App\Repository;

use App\Entity\UserToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserToken[]    findAll()
 * @method UserToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    /**
     * @param string $token
     * @return UserToken|null
     */
    public function findOneByToken(string $token): ?UserToken
    {
        try {
            return $this->createQueryBuilder('u')
                ->andWhere('u.token = :token')
                ->setParameter('token', $token)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
