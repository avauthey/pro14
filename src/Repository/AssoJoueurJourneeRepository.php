<?php

namespace App\Repository;

use App\Entity\AssoJoueurJournee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AssoJoueurJournee|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssoJoueurJournee|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssoJoueurJournee[]    findAll()
 * @method AssoJoueurJournee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssoJoueurJourneeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AssoJoueurJournee::class);
    }

    // /**
    //  * @return AssoJoueurJournee[] Returns an array of AssoJoueurJournee objects
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
    public function findOneBySomeField($value): ?AssoJoueurJournee
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function findByJourneeAndEquipe($journee,$equipe){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select a FROM App\Entity\AssoJoueurJournee a WHERE a.journee = :journee AND a.equipe = :equipe ORDER BY a.numero ASC')
                ->setParameters(array('journee'=>$journee,"equipe"=>$equipe));
        return $query->execute();
    }
}
