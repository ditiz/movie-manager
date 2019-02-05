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

    public function __construct(
        Environment $twig, 
        ManageOmdbApi $omdb
    ) {
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
                    
                    $movieFromDatabase = $this->omdb->getMovieFromDatabase($imdbID);
                    $MovieSee->setMovieId($movieFromDatabase->getId());

                    $entityManager->persist($MovieSee);

                    $modif[$movieFromDatabase->getName()] = 'ajouter à film à voir';
                } else {
                    $movieFromDatabase = $this->omdb->getMovieFromDatabase($imdbID);
                    $modif[$movieFromDatabase->getName()] = 'déjà dans ce status pour film vu';
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

    public function getWatchInfo($movies) {
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

}