<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

	public function updateMovieToSeeFromSearch(Request $request) 
    {
        $modif = [];
        $movies = $request->get('movies');

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($movies as $imdbID => $movie) {
            if (isset($movie['to_see'])) {
                $MovieToSee = $this->manageToSee($imdbID, $movie);

                if ($MovieToSee) {
                    $entityManager->persist($MovieToSee);
    
                    $movieFromDatabase = $this->omdb->getMovieFromDatabase($imdbID);
                    $modif[$movieFromDatabase->getName()] = 'ajouter à film à voir';
                }
            }

            if (isset($movie['see'])) {
                $MovieSee = $this->manageSee($imdbID, $movie);
                
                $movieFromDatabase = $this->omdb->getMovieFromDatabase($imdbID);
                if ($MovieSee) {
                    $entityManager->persist($MovieSee);
                    $modif[$movieFromDatabase->getName()] = 'ajouter à film à voir';
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

    private function manageToSee($imdbID, $movie) 
    {
        $MovieToSee = $this->getDoctrine()
            ->getRepository(MovieToSee::class)
            ->findOneBy(['imdbID' => $imdbID]);
            
        if (!isset($MovieToSee)) {
            $MovieToSee = new MovieToSee();

            $MovieToSee->setImdbId($imdbID);
            
            $toSee = $movie['to_see'] == 'on' ? 1 : 0;
            $MovieToSee->setTooSee($toSee);
            
            $movieFromDatabase = $this->omdb->getMovieFromDatabase($imdbID);
            $MovieToSee->setMovieId($movieFromDatabase->getId());
            
            return $MovieToSee;
        }
    }

    private function manageSee($imdbID, $movie)
    {
        $MovieSee = $this->getDoctrine()
            ->getRepository(MovieSee::class)
            ->findOneBy(['imdbID' => $imdbID]);

        if (!isset($MovieSee)) {
            $MovieSee = new MovieSee();

            $MovieSee->setImdbId($imdbID);
            
            $see = $movie['see'] == 'on' ? 1 : 0;
            $MovieSee->setSee($see);
            
            $movieFromDatabase = $this->omdb->getMovieFromDatabase($imdbID);
            $MovieSee->setMovieId($movieFromDatabase->getId());

            return $MovieSee;
        }
    }
}