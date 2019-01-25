<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class MovieController extends AbstractController
{

    public function index()
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();

        return $this->render('movie/index.html.twig', ['movies' => $movies]);
    }

    public function getFilmByImdbID()
    {

        $data_movie = $this->getFilm("tt0090605");

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

    function getFilm($imdb_id)
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

        
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        return json_decode($result, true);
    }

    function searchFilm() {

    }
}
