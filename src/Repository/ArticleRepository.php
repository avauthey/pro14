<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
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
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
   public function findLastFive() {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('Select a FROM App\Entity\Article a WHERE a.statut=:publie and a.type in (0,2) ORDER BY a.id DESC ')->setParameters(array('publie'=>"Publié"))->setMaxResults(4);
        return $query->execute();
   }
   public function findByTypes($statut, array $types) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('Select a FROM App\Entity\Article a WHERE a.statut=:publie AND a.type in ('. implode(",", $types).') ORDER BY a.id DESC ')
                ->setParameters(array('publie'=>$statut));
        return $query->execute();
   }
}