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
use App\Controller\ManageTmdbApiController;

class MovieListController extends AbstractController
{
    public function __construct(
        ManageOmdbApi $omdb, 
        MovieWatchingController $watching,
        ManageTmdbApiController $tmdb
    ) {
        $this->omdb = $omdb;
        $this->watching = $watching;
        $this->tmdb = $tmdb;
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

    public function getOneById ($id)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOne($id);

        return $this->json($movie);
    }

    public function getOneByTitle ($title, $year) 
    {
        $movie = $this->omdb->getMovieByTitle($title, $year);
        return $this->json($movie);
    }

    public function toSee() 
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieToSee();

        return $this->json($movies);
    }

    public function see() 
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieSee();

        return $this->json($movies);
    }

    public function lastToSeeAndSee() 
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findLastMovieToSeeAndSee();

        return $this->json($movies);
    }

    public function editToSeeStatus($imdbID) 
    {
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

    public function editSeeStatus($imdbID) 
    {
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

    public function setSee($imdbID) 
    {
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

    public function setToSee($imdbID) 
    {
        $entityManager = $this->getDoctrine()->getManager();

        $res = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieWithWatchingInfo($imdbID);

        if ($res) {
            list($movie, $movie_to_see, $movie_see) = $res;
        } 

        if (empty($movie) || !$movie) {
            $movie = $this->omdb->getMovieByImdbID($imdbID);
            if (!$movie) {
                return $this->json(false);
            }
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

        if (isset($movies['Search'])) {
            $movies['Search'] = $this->addWatchingInfoToMovies($movies['Search']);
        }

        return $this->json($movies);
    }

    public function watchingInfo($imdbID) 
    {
        $watchingInfo = $this->watching->getWatchingInfoByImdbId($imdbID);
 
        if ($watchingInfo['to_see']) {
            $watchingInfo['to_see'] = $watchingInfo['to_see']->getToSee();
        }

        if ($watchingInfo['see']) {
            $watchingInfo['see'] = $watchingInfo['see']->getSee();
        }
        
        return $this->json($watchingInfo);
    }

    public function addWatchingInfoToMovies(Array $movies) 
    {
        $imdbIDs = [];
        
        foreach ($movies as $movie) {
            $imdbIDs[] = $movie['imdbID'];
        } 

        $watchingInfos = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieWithWatchingByImdbIDs($imdbIDs);        

        foreach ($movies as $index => $movie) {
            foreach ($watchingInfos as $watchingInfo) {
                if ($movie['imdbID'] == $watchingInfo['m_imdbID']) {
                    $movie['to_see'] = $watchingInfo['mts_to_see'];
                    $movie['see'] = $watchingInfo['ms_see'];
                }
            }
            $movies[$index] = $movie;
        }

        return $movies;
    }

    public function discoverMovies() {
        $movies = $this->tmdb->discoverMovies();
        return new Response(json_encode($movies));
    }
}