<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;

class ManageOmdbApi extends AbstractController
{

    private $apikey = '92ff3a7a';
    private $hostapi = 'http://www.omdbapi.com/';

    public function getMovieByImdbID($imdbID)
    {
        $data_movie = $this->getMovie($imdbID);

        $movie = new Movie();

        $movie->setName($data_movie['Title']);
        $movie->setYear(intval($data_movie['Year']));
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
        $movie->setMetascore(intval($data_movie['Metascore']));
        $movie->setImdbRating(floatval($data_movie['imdbRating']));
        $movie->setImdbVotes(floatval($data_movie['imdbVotes']));
        $movie->setImdbID($data_movie['imdbID']);
        $movie->setPoster($data_movie['Poster']);

        $boxOffice = isset($data_movie['BoxOffice']) ? $data_movie['BoxOffice'] : 'N/A';
        $movie->setBoxoffice($boxOffice);

        $production = isset($data_movie['Production']) ? $data_movie['Production'] : 'N/A';
        $movie->setProduction($production);

        if(isset($data_movie['DVD'])) {
            $date_DVD = date('Y-m-d H:i:s', strtotime($data_movie['DVD']));
        } else {
            $date_DVD = date('Y-m-d H:i:s', 0);
        }
        $movie->setDVD($date_DVD);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($movie);
        $entityManager->flush();

        return $movie;
    }

    private function getMovie($imdb_id)
    {
        $params = [
            'apikey' => $this->apikey,
            'i' => $imdb_id
        ];

       $result = useApi($params);

        return json_decode($result, true);
    }

    public function getMovieByTitle (string $title, int $year) 
    {
        $params = [
            'apikey' => $this->apikey,
            't' => $title,
            'y' => $year,
        ];

        $result = useApi($params);

        return json_decode($result, true);
    }

    public function useApi (array $params) 
    {
        $params = http_build_query($params);
        $url = $this->hostapi . '?' . $params;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    public function getMovieFromDatabase(string $imdbID)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOneBy(['imdbID' => $imdbID]);

        if (!$movie) {
            $movie = $this->getMovieByImdbID($imdbID);
        }

        return $movie;
    }

    public function searchMovie(string $search, int $page = 1) : array
    {
        $params = [
            'apikey' => '92ff3a7a',
            's' => trim($search),
            'page' => $page,
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