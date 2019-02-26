<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    // /**
    //  * @return Movie[] Returns an array of Movie objects
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
    public function findMovieWithWatchingByImdbIDs($imdbIDList)
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('App\Entity\MovieToSee', 'mts', 'WITH', 'm.id = mts.movie_id')
            ->leftJoin('App\Entity\MovieSee', 'ms', 'WITH', 'm.id = ms.movie_id')
            ->where('m.imdbID IN (:imdbIDList)')
            ->setParameter('imdbIDList', $imdbIDList)
            ->select('m, mts, ms')
            ->orderBy('m.id', 'ASC')
            ->groupBy('m.id, mts.id, ms.id')
            ->getQuery()
            ->getScalarResult();
    }

    /**
    * @return MovieSee[] Returns an array of MovieSee objects
    */
    public function findMovieToSee()
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('App\Entity\MovieToSee', 'mts', 'WITH', 'm.id = mts.movie_id')
            ->select('m, mts')
            ->orderBy('m.id', 'ASC')
            ->groupBy('m.id, mts.id')
            ->where('mts.to_see = 1')
            ->getQuery()
            ->getScalarResult();
    }    


    /**
    * @return MovieSee[] Returns an array of MovieSee objects
    */
    public function findMovieSee()
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('App\Entity\MovieSee', 'ms', 'WITH', 'm.id = ms.movie_id')
            ->select('m, ms')
            ->orderBy('m.id', 'ASC')
            ->groupBy('m.id, ms.id')
            ->where('ms.see = 1')
            ->getQuery()
            ->getScalarResult();
    }  
    
    /**
    * @return MovieSee[] Returns an array of MovieSee objects
    */
    public function findLastMovieToSeeAndSee()
    {
        $movies['toSee'] = $this->createQueryBuilder('m')
            ->innerJoin('App\Entity\MovieToSee', 'mts', 'WITH', 'm.id = mts.movie_id')
            ->select('m')
            ->orderBy('m.id', 'ASC')
            ->groupBy('m.id, mts.id')
            ->orderBy('mts.id', 'Desc')
            ->where('mts.to_see = 1')
            ->setmaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

         $movies['see'] = $this->createQueryBuilder('m')
            ->innerJoin('App\Entity\MovieSee', 'ms', 'WITH', 'm.id = ms.movie_id')
            ->select('m')
            ->orderBy('m.id', 'ASC')
            ->groupBy('m.id, ms.id')
            ->orderBy('ms.id', 'Desc')
            ->where('ms.see = 1')
            ->setmaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $movies;
    }

    public function findMovieWithWatchingInfo($imdbID) 
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('App\Entity\MovieToSee', 'mts', 'WITH', 'm.id = mts.movie_id')
            ->leftJoin('App\Entity\MovieSee', 'ms', 'WITH', 'm.id = ms.movie_id')
            ->where('m.imdbID = :imdbID')
            ->setParameter('imdbID', $imdbID)
            ->select('m, mts, ms')
            ->orderBy('m.id', 'ASC')
            ->groupBy('m.id, mts.id, ms.id')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Movie
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
