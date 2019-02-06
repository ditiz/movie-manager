<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

use App\Entity\Movie;
use App\Entity\MovieToSee;
use App\Entity\MovieSee;

use App\Controller\MovieWatchingController;

class MovieToSeeController extends AbstractController
{
    private $twig;
    private $watching;

    public function __construct(Environment $twig, MovieWatchingController $watching) {
        $this->twig = $twig;
        $this->watching = $watching;
    }

    public function index()
    {
        $movies = $this->getDoctrine()
            ->getRepository(MovieToSee::class)
            ->findAllMovieToSeeJoinMovie(1);

        $watch_infos = $this->watching->getWatchInfoObject($movies);

        $response = $this->twig->render('movie/listMovie.html.twig', [
            'title' => 'Liste des films à voir',
            'movies' => $movies,
            'watch_infos' => $watch_infos,
        ]);

        return new Response($response);
    }
}
