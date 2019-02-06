<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

use App\Entity\Movie;
use App\Entity\MovieSee;
use App\Entity\MovieToSee;

use App\Controller\ManageOmdbApi;
use App\Controller\MovieWatchingController;


class MovieController extends AbstractController
{
    private $twig;
    private $omdb;
    private $watching;

    public function __construct(
        Environment $twig, 
        ManageOmdbApi $omdb,
        MovieWatchingController $watching
    ) {
        $this->twig = $twig;
        $this->omdb = $omdb;
        $this->watching = $watching;
    }

    public function listMovies()
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();

        return $this->render('movie/index.html.twig', ['movies' => $movies]);
    }

    public function getSearchPage($messages = []) 
    {
        $response = $this->twig->render('movie/search.html.twig', [
            'search' => '',
            'messages' => $messages
        ]);

        return new Response($response);
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

            $watch_infos = $this->watching->getWatchInfoArray($results);

            $response = $this->twig->render('movie/search.html.twig',[
                'results' => $results,
                'search' => $search,
                'page' => $page,
                'watch_infos' => $watch_infos
            ]);

            return new Response($response);
        }
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