<?php

namespace App\Repository;

use App\Entity\UserInvestment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserInvestment|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserInvestment|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInvestment[]    findAll()
 * @method UserInvestment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserInvestmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserInvestment::class);
    }

    // /**
    //  * @return UserInvestment[] Returns an array of UserInvestment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserInvestment
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
