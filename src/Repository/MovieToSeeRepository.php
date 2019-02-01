<?php

namespace App\Repository;

use App\Entity\MovieToSee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MovieToSee|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieToSee|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieToSee[]    findAll()
 * @method MovieToSee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieToSeeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MovieToSee::class);
    }

    // /**
    //  * @return MovieToSee[] Returns an array of MovieToSee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

     /**
    * @return MovieToSee[] Returns an array of MovieToSee objects
    */
    public function findAllMovieToSeeJoinMovie($to_see)
    {
        return $this->createQueryBuilder('mts')
            ->innerJoin('App\Entity\Movie', 'm')
            ->andWhere('m.id = mts.movie_id AND mts.to_see = :to_see')
            ->setParameter('to_see', $to_see)
            ->select('m')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?MovieToSee
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
