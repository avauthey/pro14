<?php

namespace App\Repository;

use App\Entity\Joueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Joueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joueur[]    findAll()
 * @method Joueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joueur::class);
    }

    // /**
    //  * @return Joueur[] Returns an array of Joueur objects
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
    public function findOneBySomeField($value): ?Joueur
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByPrenomNom($nom){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                'Select j FROM App\Entity\Joueur j WHERE j.prenom LIKE :prenom OR j.nom LIKE :nom ORDER BY j.id ASC')
                ->setParameters(array('prenom'=>"%$nom%","nom"=>"%$nom%"));
        return $query->execute();
    }
    
    public function getNationalites(){
        $connexion = $this->getEntityManager()->getConnection();
        $sql = 'SELECT pays_naissance, COUNT(*) AS nb FROM joueur GROUP BY pays_naissance ORDER BY pays_naissance';
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}
