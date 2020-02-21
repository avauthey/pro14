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
    
    public function findRealisateur($saison){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select a joueur, sum(a.points) p, SUM(a.essais), SUM(a.penalite), SUM(a.transformation), sum(a.drops) FROM App\Entity\AssoJoueurJournee a WHERE a.journee IN (SELECT j.id FROM App\Entity\Journee j where j.saison=:saison) GROUP BY a.joueur ORDER BY p DESC')
                ->setParameters(array('saison'=>$saison))
                ->setMaxResults(10);
        return $query->execute();
    }
    public function findMarqueur($saison){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select a joueur, sum(a.essais) essais, SUM(a.points) points FROM App\Entity\AssoJoueurJournee a WHERE a.journee IN (SELECT j.id FROM App\Entity\Journee j where j.saison=:saison) GROUP BY a.joueur ORDER BY essais DESC')
                ->setParameters(array('saison'=>$saison))
                ->setMaxResults(10);
        return $query->execute();
    }
    public function findRealisateurByEquipe($saison, $equipe){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select a joueur, sum(a.points) points, SUM(a.essais) essais, SUM(a.penalite) penalites, SUM(a.transformation) transformations, sum(a.drops) drops '
                . 'FROM App\Entity\AssoJoueurJournee a '
                . 'WHERE a.journee IN (SELECT j.id FROM App\Entity\Journee j where j.saison=:saison) AND a.joueur IN (Select IDENTITY(e.idJoueur) FROM App\Entity\AssoJoueurEquipe e WHERE e.saison=:saison AND e.idEquipe=:equipe) '
                . 'GROUP BY a.joueur '
                . 'ORDER BY points DESC')
                ->setParameters(array('saison'=>$saison,'equipe'=>$equipe))
                ->setMaxResults(5);
        return $query->execute();
    }
    
    public function findMarqueurByEquipe($saison, $equipe){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select a joueur, sum(a.essais) essais, SUM(a.points) points '
                . 'FROM App\Entity\AssoJoueurJournee a '
                . 'WHERE a.journee IN (SELECT j.id FROM App\Entity\Journee j where j.saison=:saison) AND a.joueur IN (Select IDENTITY(e.idJoueur) FROM App\Entity\AssoJoueurEquipe e WHERE e.saison=:saison AND e.idEquipe=:equipe) '
                . 'GROUP BY a.joueur '
                . 'ORDER BY essais DESC')
                ->setParameters(array('saison'=>$saison,'equipe'=>$equipe))
                ->setMaxResults(5);
        return $query->execute();
    }
    public function findPlaqueurByEquipe($saison, $equipe){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select a joueur, sum(a.placagesReussis) reussis, SUM(a.placagesManques) manques '
                . 'FROM App\Entity\AssoJoueurJournee a '
                . 'WHERE a.journee IN (SELECT j.id FROM App\Entity\Journee j where j.saison=:saison) AND a.joueur IN (Select IDENTITY(e.idJoueur) FROM App\Entity\AssoJoueurEquipe e WHERE e.saison=:saison AND e.idEquipe=:equipe) '
                . 'GROUP BY a.joueur '
                . 'ORDER BY reussis DESC')
                ->setParameters(array('saison'=>$saison,'equipe'=>$equipe))
                ->setMaxResults(5);
        return $query->execute();
    }
    public function findCourseMetreByEquipe($saison, $equipe){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select a joueur, sum(a.course) courses, SUM(a.metreGagne) metresGagnes, SUM(a.perce) percees '
                . 'FROM App\Entity\AssoJoueurJournee a '
                . 'WHERE a.journee IN (SELECT j.id FROM App\Entity\Journee j where j.saison=:saison) AND a.joueur IN (Select IDENTITY(e.idJoueur) FROM App\Entity\AssoJoueurEquipe e WHERE e.saison=:saison AND e.idEquipe=:equipe) '
                . 'GROUP BY a.joueur '
                . 'ORDER BY metresGagnes DESC')
                ->setParameters(array('saison'=>$saison,'equipe'=>$equipe))
                ->setMaxResults(5);
        return $query->execute();
    }
    public function findDisciplineByEquipe($saison, $equipe){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select a joueur, sum(a.penaliteConcedee) fautes, SUM(a.CJ) jaune, SUM(a.CR) rouge '
                . 'FROM App\Entity\AssoJoueurJournee a '
                . 'WHERE a.journee IN (SELECT j.id FROM App\Entity\Journee j where j.saison=:saison) AND a.joueur IN (Select IDENTITY(e.idJoueur) FROM App\Entity\AssoJoueurEquipe e WHERE e.saison=:saison AND e.idEquipe=:equipe) '
                . 'GROUP BY a.joueur '
                . 'ORDER BY fautes DESC')
                ->setParameters(array('saison'=>$saison,'equipe'=>$equipe))
                ->setMaxResults(5);
        return $query->execute();
    }
}
