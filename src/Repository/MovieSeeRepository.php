<?php

namespace App\Repository;

use App\Entity\MovieSee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MovieSee|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieSee|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieSee[]    findAll()
 * @method MovieSee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieSeeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MovieSee::class);
    }

    // /**
    //  * @return MovieSee[] Returns an array of MovieSee objects
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
    * @return MovieSee[] Returns an array of MovieSee objects
    */
    public function findAllMovieSeeJoinMovie($see)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT ms, m
            FROM App\Entity\MovieSee ms
            JOIN App\Entity\Movie m
            WHERE ms.see = :see
            ORDER BY m.id'
        )->setParameter('see', $see)->execute();
    }

    /*
    public function findOneBySomeField($value): ?MovieSee
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
