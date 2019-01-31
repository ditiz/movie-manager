<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;
use App\Entity\MovieSee;

class MovieSeeController extends AbstractController
{
    public function index()
    {
        $movies = $this->getDoctrine()
            ->getRepository(MovieSee::class)
            ->findAllMovieSeeJoinMovie(1);
        

        return $this->render('movie_see/index.html.twig', [
            'movies' => $movies,
        ]);
    }
}
