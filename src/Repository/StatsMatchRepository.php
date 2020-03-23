<?php

namespace App\Repository;

use App\Entity\StatsMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatsMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatsMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatsMatch[]    findAll()
 * @method StatsMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatsMatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatsMatch::class);
    }

    // /**
    //  * @return StatsMatch[] Returns an array of StatsMatch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatsMatch
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
