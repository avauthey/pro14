<?php

namespace App\Repository;

use App\Entity\AssoJoueurEquipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AssoJoueurEquipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssoJoueurEquipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssoJoueurEquipe[]    findAll()
 * @method AssoJoueurEquipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssoJoueurEquipeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AssoJoueurEquipe::class);
    }

    // /**
    //  * @return AssoJoueurEquipe[] Returns an array of AssoJoueurEquipe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AssoJoueurEquipe
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
