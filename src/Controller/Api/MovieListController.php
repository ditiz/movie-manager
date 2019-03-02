<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Movie;
use App\Entity\MovieSee;
use App\Entity\MovieToSee;
use App\Controller\ManageOmdbApi;
use App\Controller\MovieWatchingController;

class MovieListController extends AbstractController
{
    public function __construct(ManageOmdbApi $omdb, MovieWatchingController $watching) {
        $this->omdb = $omdb;
        $this->watching = $watching;
    }


	public function index()
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();

        return $this->json($movies);
    }

    public function getOneByImdbID($imdbID)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOneBy(['imdbID' => $imdbID]);

        if ($movie == null) {
            //Get the movie from imdb
            $movie = $this->omdb->getMovieByImdbID($imdbID);
        }

        return $this->json($movie);
    }

    public function getOneById($id)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOne($id);

        return $this->json($movie);
    }

    public function toSee() {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieToSee();

        return $this->json($movies);
    }

    public function see() {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieSee();

        return $this->json($movies);
    }

    public function lastToSeeAndSee() {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findLastMovieToSeeAndSee();

        return $this->json($movies);
    }

    public function editToSeeStatus($imdbID) {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOneBy(['imdbID' => $imdbID]);
        
        if (!$movie) {
            //we save the movie in database 
            $this->omdb->getMovieByImdbID($imdbID);
        }

        $this->watching->inverseToSeeStatus($imdbID);
        return $this->json(true);
    }

    public function editSeeStatus($imdbID) {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOneBy(['imdbID' => $imdbID]);
        
        if (!$movie) {
            //we save the movie in database 
            $this->omdb->getMovieByImdbID($imdbID);
        }

        $this->watching->inverseSeeStatus($imdbID);
        return $this->json(true);
    }

    public function setSee($imdbID) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $res = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieWithWatchingInfo($imdbID);

        if ($res) {
            list($movie, $movie_to_see, $movie_see) = $res;
        }
        
        if (empty($movie) || !$movie) {
            //we save the movie in database 
            $movie = $this->omdb->getMovieByImdbID($imdbID);
        }

        if (isset($movie_to_see)) {
            $movie_to_see->setToSee(0);
            $entityManager->persist($movie_to_see);
        }
        
        if (empty($movie_see) || !$movie_see) {
            $movie_see = new MovieSee();

            $movie_see
                ->setImdbId($imdbID)
                ->setMovieId($movie->getId());

            $movie_see_status = 1;
        } else {
            $movie_see_status = !$movie_see->getSee();
        }

        $movie_see->setSee($movie_see_status);
        
        $entityManager->persist($movie_see);
        $entityManager->flush();

        return $this->json(true);
    } 

    public function setToSee($imdbID) {
        $entityManager = $this->getDoctrine()->getManager();

        $res = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieWithWatchingInfo($imdbID);

        if ($res) {
            list($movie, $movie_to_see, $movie_see) = $res;
        } 

       if (empty($movie) || !$movie) {
            $movie = $this->omdb->getMovieByImdbID($imdbID);
        }

        if (isset($movie_see) && $movie_see) {
            $movie_see->setSee(0);
            $entityManager->persist($movie_see);
        }
        
        
        if (empty($movie_to_see) || !$movie_to_see) {
            $movie_to_see = new MovieToSee();
            
            $movie_to_see
                ->setImdbId($imdbID)
                ->setMovieId($movie->getId());

            $movie_to_see_status = 1;
        } else {
            $movie_to_see_status = !$movie_to_see->getToSee();
        }

        $movie_to_see->setToSee($movie_to_see_status);

        $entityManager->persist($movie_to_see);
        $entityManager->flush();

        return $this->json(true);
    }

    public function search($search, $page = 1)
    {
        $movies = $this->omdb->searchMovie($search, $page);

        return $this->json($movies);
    }
}