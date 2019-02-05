<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\ManageOmdbApi;
use Twig\Environment;

class MovieDetailController extends AbstractController
{
    public function __construct(Environment $twig, ManageOmdbApi $omdb)
    {
        $this->twig = $twig;
        $this->omdb = $omdb;
    }

    public function index($imdbID)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOneBy(['imdbID' => $imdbID]);

        if ($movie == null) {
            $movie = $this->omdb->getMovieByImdbID($imdbID);
        }

        $response = $this->twig->render('movie_detail/index.html.twig', [
            'movie' => $movie,
        ]);

        return new Response($response);
    }
}
