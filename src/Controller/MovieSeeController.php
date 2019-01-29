<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieSeeController extends AbstractController
{
    /**
     * @Route("/movie/see", name="movie_see")
     */
    public function index()
    {
        return $this->render('movie_see/index.html.twig', [
            'controller_name' => 'MovieSeeController',
        ]);
    }
}
