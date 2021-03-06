<?php

namespace App\Repository;

use App\Entity\Journee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Journee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Journee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Journee[]    findAll()
 * @method Journee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JourneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Journee::class);
    }

    // /**
    //  * @return Journee[] Returns an array of Journee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Journee
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function findJourneeByIdEquipe($value, $saison){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select j FROM App\Entity\Journee j WHERE (j.idEquipeHome = :home OR j.idEquipeAway = :away) AND j.saison = :saison ORDER BY j.id ASC')
                ->setParameters(array('home'=>$value,'away'=>$value,'saison'=>$saison));
        return $query->execute();
    }
    
    public function findLastJourneePlayed($saison){
        $entityManager = $this->getEntityManager();
                
        $query = $entityManager->createQuery(
                'Select j FROM App\Entity\Journee j WHERE j.journee IN ('
                . 'SELECT jb.journee FROM App\Entity\Journee jb WHERE jb.id = ('
                . 'SELECT MAX(jc.id) FROM App\Entity\Journee jc '
                . 'WHERE jc.saison=:saison AND (jc.scoreHome is not null AND jc.scoreAway is not null)'
                . '))'
                . 'AND j.saison=:saison ORDER BY j.id ASC')
                
                ->setParameters(array('saison'=>$saison));
        return $query->execute();
    }
    
    public function findPointsByEquipe($saison, $equipe){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select j FROM App\Entity\Journee j WHERE j.saison = :saison AND (j.idEquipeHome = :equipe OR j.idEquipeAway = :equipe) ORDER BY j.id ASC')
                ->setParameters(array('saison'=>$saison, 'equipe'=>$equipe));
        return $query->execute();
    }
    
}
