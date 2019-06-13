<?php

namespace App\Repository;

use App\Entity\Palmares;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Palmares|null find($id, $lockMode = null, $lockVersion = null)
 * @method Palmares|null findOneBy(array $criteria, array $orderBy = null)
 * @method Palmares[]    findAll()
 * @method Palmares[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PalmaresRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Palmares::class);
    }

    // /**
    //  * @return Palmares[] Returns an array of Palmares objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Palmares
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
