<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends AbstractController
{

    public function listMovies()
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();

        return $this->render('movie/index.html.twig', ['movies' => $movies]);
    }

    public function apiListMovies()
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();

        return $this->json($movies);
    }

    public function getSearchPage() {
        return $this->render('movie/search.html.twig', ['search' => '']);
    }

    public function useSearchPage(Request $request) {
        $search = $request->get('search');

        $results = $this->searchMovie($search);

        return $this->render('movie/search.html.twig',[
            'results' => $results['Search'],
            'search' => $search
        ]);
    }
    
    private function getMovieByImdbID()
    {

        $data_movie = $this->getMovie("tt0090605");

        $movie = new Movie();

        $movie->setName($data_movie['Title']);
        $movie->setYear($data_movie['Year']);
        $movie->setRated($data_movie['Rated']);
        $movie->setReleased($data_movie['Released']);
        $movie->setRuntime($data_movie['Runtime']);
        $movie->setGenre($data_movie['Genre']);
        $movie->setDirector($data_movie['Director']);
        $movie->setWriter($data_movie['Writer']);
        $movie->setActors($data_movie['Actors']);
        $movie->setPlot($data_movie['Plot']);
        $movie->setLanguages($data_movie['Language']);
        $movie->setCountry($data_movie['Country']);
        $movie->setAwards($data_movie['Awards']);
        $movie->setRating($data_movie['Ratings']);
        $movie->setMetascore($data_movie['Metascore']);
        $movie->setImdbRating($data_movie['imdbRating']);
        $movie->setImdbVotes(floatval($data_movie['imdbVotes']));
        $movie->setImdbID($data_movie['imdbID']);
        $movie->setPoster($data_movie['Poster']);
        $movie->setBoxoffice($data_movie['BoxOffice']);
        $movie->setProduction($data_movie['Production']);

        $date = new \DateTime('@'.strtotime($data_movie['DVD']));
        $movie->setDVD($date);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($movie);
        $entityManager->flush();

        return new Response('Saved new product with id ' . $movie->getId());
    }

    private function getMovie($imdb_id)
    {
        $params = [
            'apikey' => '92ff3a7a',
            'i' => $imdb_id
        ];

        $params = '?' . http_build_query($params);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.omdbapi.com/' . $params
        ));

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true);
    }

    private function searchMovie($search) 
    {
        $params = [
            'apikey' => '92ff3a7a',
            's' => $search
        ];

        $params = '?' . http_build_query($params);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.omdbapi.com/' . $params
        ));

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true);
    }
}
