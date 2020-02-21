<?php

namespace App\Repository;

use App\Entity\Classement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Classement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classement[]    findAll()
 * @method Classement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Classement::class);
    }

    // /**
    //  * @return Classement[] Returns an array of Classement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Classement
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLastClassementPlayed($saison){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select c FROM App\Entity\Classement c WHERE c.journee IN (SELECT MAX(cb.journee) FROM App\Entity\Classement cb WHERE cb.saison = :saison) AND c.saison = :saison ORDER BY c.classement,c.conference ASC')
                ->setParameters(array('saison'=>$saison));
        return $query->execute();
    }
    public function findLastClassementPlayedByConf($saison,$conference){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select c FROM App\Entity\Classement c WHERE c.journee IN (SELECT MAX(cb.journee) FROM App\Entity\Classement cb WHERE cb.saison = :saison ) AND c.conference = :conf AND c.saison = :saison ORDER BY c.classement ASC')
                ->setParameters(array('saison'=>$saison,'conf'=>$conference));
        return $query->execute();
    }
    public function findAllClassementBySaisonConf($saison,$conference){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select c FROM App\Entity\Classement c WHERE c.saison = :saison AND c.conference = :conf ORDER BY c.id,c.classement,c.conference ASC')
                ->setParameters(array('saison'=>$saison,'conf'=>$conference));
        return $query->execute();
    }
    public function findLastByEquipe($equipe){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select c FROM App\Entity\Classement c WHERE c.equipe = :equipe ORDER BY c.id DESC')
                ->setParameters(array('equipe'=>$equipe,))
                ->setMaxResults(1);
        return $query->execute();
    }
}
