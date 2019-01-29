<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;

class MovieDetailController extends AbstractController
{
    public function index($imdbID)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOneBy(['imdbID' => $imdbID]);

        if ($movie == null) {
            return false;
        }

        return $this->render('movie_detail/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}
