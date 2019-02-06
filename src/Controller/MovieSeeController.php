<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

use App\Entity\Movie;
use App\Entity\MovieToSee;
use App\Entity\MovieSee;

use App\Controller\MovieWatchingController;

class MovieSeeController extends AbstractController
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
            ->getRepository(moviesee::class)
            ->findAllMovieSeeJoinMovie(1);

        $watch_infos = $this->watching->getWatchInfoObject($movies);

        $response = $this->twig->render('movie/listMovie.html.twig', [
            'title' => 'Liste des films vu',
            'movies' => $movies,
            'watch_infos' => $watch_infos,
        ]);

        return new Response($response);
    }
}
