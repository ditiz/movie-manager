<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;
use App\Entity\MovieToSee;
use App\Entity\MovieSee;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\ManageOmdbApi;
use Twig\Environment;

class MovieWatchingController extends AbstractController
{
	private $twig;
    private $omdb;

    public function __construct(Environment $twig, ManageOmdbApi $omdb) {
        $this->twig = $twig;
        $this->omdb = $omdb;
    }

    public function getWatchInfoArray($movies) {
        $watch_infos = [];
        foreach ($movies as $movie) {
            $watch_infos['toSee'][$movie['imdbID']] = $this->getDoctrine()
                ->getRepository(MovieToSee::class)
                ->findOneBy(['imdbID' => $movie['imdbID'], 'to_see' => 1]);

            $watch_infos['see'][$movie['imdbID']] = $this->getDoctrine()
                ->getRepository(MovieSee::class)
                ->findOneBy(['imdbID' => $movie['imdbID'], 'see' => 1]);
        }

        if ($watch_infos == []) {
            return false;
        }

        return $watch_infos;
    }

    public function getWatchInfoObject($movies) {
        $watch_infos = [];
        foreach ($movies as $movie) {
            $watch_infos['toSee'][$movie->getimdbID()] = $this->getDoctrine()
                ->getRepository(MovieToSee::class)
                ->findOneBy(['imdbID' =>$movie->getimdbID(), 'to_see' => 1]);

            $watch_infos['see'][$movie->getimdbID()] = $this->getDoctrine()
                ->getRepository(MovieSee::class)
                ->findOneBy(['imdbID' => $movie->getimdbID(), 'see' => 1]);
        }

        if ($watch_infos == []) {
            return false;
        }

        return $watch_infos;
    }

	public function updateMovieToSeeFromSearch(Request $request) 
    {
        $modif = [];
        $movies = $request->get('movies');

        $imdbIDList = array_keys($movies);
        $databaseMoviesInfos = [];

        foreach ($imdbIDList as $imdbID) {
            $index = 'm_imdbID';
            $movie = $this->getDoctrine()
                ->getRepository(Movie::class)
                ->findMovieWithWatchingByImdbIDs([$imdbID]);
 
            if (!$movie) {
                $movie = $this->omdb->getMovieByImdbID($imdbID);
                 $movie = $this->getDoctrine()
                ->getRepository(Movie::class)
                ->findMovieWithWatchingByImdbIDs([$imdbID]);
            }

            $movie = $movie[0];
            $databaseMoviesInfos[$movie[$index]] = $movie;
        }
            
        $entityManager = $this->getDoctrine()->getManager();
        
        foreach ($databaseMoviesInfos as $movieInfos) {
            //Manage MovieToSee
            if (isset($movies[$movieInfos['m_imdbID']]['to_see'])) {
                if ($movieInfos['mts_to_see'] == 0 || $movieInfos['mts_to_see'] == null) {
                    $movieToSee = $this->manageToSee($movieInfos['m_imdbID'], 1);
                    $entityManager->persist($movieToSee);
                }
            } else {
                if ($movieInfos['mts_to_see'] != 0 || $movieInfos['mts_to_see'] != null) {
                    $movieToSee = $this->manageToSee($movieInfos['m_imdbID'], 0);
                    $entityManager->persist($movieToSee);
                }
            }
            
            //Manage MovieSee
            if (isset($movies[$movieInfos['m_imdbID']]['see'])) {
                if ($movieInfos['ms_see'] == 0 || $movieInfos['ms_see'] == null) {
                    $movieSee = $this->manageSee($movieInfos['m_imdbID'], 1);
                    $entityManager->persist($movieSee);
                }
            } else {
                if ($movieInfos['ms_see'] != 0 || $movieInfos['ms_see'] != null) {
                    $movieSee = $this->manageSee($movieInfos['m_imdbID'], 0);
                    $entityManager->persist($movieSee);
                }
            } 
        }

        $entityManager->flush();


        $response = $this->twig->render('movie/search.html.twig', [
            'search' => '',
            'messages' => $modif
		]);
		
		return new Response($response);
    }

    private function manageToSee($imdbID, $status) 
    {
        $MovieToSee = $this->getDoctrine()
            ->getRepository(MovieToSee::class)
            ->findOneBy(['imdbID' => $imdbID]);

        if (!isset($MovieToSee)) {
            $MovieToSee = new MovieToSee();
            $MovieToSee->setImdbId($imdbID);
        }

        $MovieToSee->setToSee($status);
        
        $movieFromDatabase = $this->omdb->getMovieFromDatabase($imdbID);
        $MovieToSee->setMovieId($movieFromDatabase->getId());
        
        return $MovieToSee;
    }

    private function manageSee($imdbID, $status)
    {
        $MovieSee = $this->getDoctrine()
            ->getRepository(MovieSee::class)
            ->findOneBy(['imdbID' => $imdbID]);

        if (!isset($MovieSee)) {
            $MovieSee = new MovieSee();
            $MovieSee->setImdbId($imdbID);
        }
        
        $MovieSee->setSee($status);
        
        $movieFromDatabase = $this->omdb->getMovieFromDatabase($imdbID);
        $MovieSee->setMovieId($movieFromDatabase->getId());

        return $MovieSee;
    }
}