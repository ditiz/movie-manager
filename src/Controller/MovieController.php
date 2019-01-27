<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use App\Entity\MovieSee;
use App\Entity\MovieToSee;
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

    public function getSearchPage($messages = []) 
    {
        return $this->render('movie/search.html.twig', [
            'search' => '',
            'messages' => $messages
        ]);
    }

    public function useSearchPage(Request $request) {
        $search = $request->get('search');
        $page = $request->get('page');

        $page = isset($page) ? $page : 1;

        $results = $this->searchMovie($search, $page);

        if ($results['Response'] == 'False') {
            return $this->render('movie/search.html.twig',[
                'error' => $results['Error'],
                'search' => $search
            ]);
        } else {
            $results = $results['Search'];

            $watch_infos = $this->getWatchInfo($results);

            return $this->render('movie/search.html.twig',[
                'results' => $results,
                'search' => $search,
                'page' => $page,
                'watch_infos' => $watch_infos
            ]);
        }
    }

    public function updateMovieToSeeFromSearch(Request $request) 
    {
        $modif = [];
        $movies = $request->get('movies');

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($movies as $imdbID => $movie) {
            if (isset($movie['to_see'])) {
                $MovieToSee = $this->getDoctrine()
                    ->getRepository(MovieToSee::class)
                    ->findOneBy(['imdbID' => $imdbID]);
                    
                if (!isset($MovieToSee)) {
                    $MovieToSee = new MovieToSee();

                    $MovieToSee->setImdbId($imdbID);
                    
                    $toSee = $movie['to_see'] == 'on' ? 1 : 0;
                    $MovieToSee->setTooSee($toSee);
                    
                    $movieFromDatabase = $this->getMovieFromDatabase($imdbID);
                    $MovieToSee->setMovieId($movieFromDatabase->getId());

                    $entityManager->persist($MovieToSee);

                    $modif[$movieFromDatabase->getName()] = 'ajouter à film à voir';
                } else {
                    $modif[$movieFromDatabase->getName()] = 'déjà dans ce status pour film à voir';
                }
            }

            if (isset($movie['see'])) {

                $MovieSee = $this->getDoctrine()
                    ->getRepository(MovieSee::class)
                    ->findOneBy(['imdbID' => $imdbID]);

                if (!isset($MovieSee)) {
                    $MovieSee = new MovieSee();

                    $MovieSee->setImdbId($imdbID);
                    
                    $see = $movie['see'] == 'on' ? 1 : 0;
                    $MovieSee->setSee($see);
                    
                    $movieFromDatabase = $this->getMovieFromDatabase($imdbID);
                    $MovieSee->setMovieId($movieFromDatabase->getId());

                    $entityManager->persist($MovieSee);

                    $modif[$movieFromDatabase->getName()] = 'ajouter à film à voir';
                } else {
                    $movieFromDatabase = $this->getMovieFromDatabase($imdbID);
                    $modif[$movieFromDatabase->getName()] = 'déjà dans ce status pour film vu';
                }
            }
        }
        $entityManager->flush();


        $response = $this->forward('App\Controller\MovieController::getSearchPage', [
            'messages' => $modif
        ]);

        return $response;
    }

    private function getWatchInfo($movies) {
        $watch_infos = [];
        foreach ($movies as $movie) {
            $watch_infos['toSee'][$movie['imdbID']] = $this->getDoctrine()
                ->getRepository(MovieToSee::class)
                ->findOneBy(['imdbID' => $movie['imdbID'], 'too_see' => 1]);

            $watch_infos['see'][$movie['imdbID']] = $this->getDoctrine()
                ->getRepository(MovieSee::class)
                ->findOneBy(['imdbID' => $movie['imdbID'], 'see' => 1]);
        }

        if ($watch_infos == []) {
            return false;
        }

        return $watch_infos;
    }

    private function getMovieFromDatabase(string $imdbID)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOneBy(['imdbID' => $imdbID]);

        if (!$movie) {
            $movie = $this->getMovieByImdbID($imdbID);
        }

        return $movie;
    }
    
    private function getMovieByImdbID($imdbID)
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
            $date_DVD = '00-00-0000 00:00:00';
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

    private function searchMovie($search, int $page = 1) : array
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

function dd(...$params) {
    foreach($params as $param) {
        dump($param);
    }
    die;
}
