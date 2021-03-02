<?php

namespace App\Repository;

use App\Entity\RecipeVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecipeVote|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeVote|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeVote[]    findAll()
 * @method RecipeVote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeVoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeVote::class);
    }

    // /**
    //  * @return RecipeVote[] Returns an array of RecipeVote objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecipeVote
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
