<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieToSeeController extends AbstractController
{
    /**
     * @Route("/movie/to/see", name="movie_to_see")
     */
    public function index()
    {
        return $this->render('movie_to_see/index.html.twig', [
            'controller_name' => 'MovieToSeeController',
        ]);
    }
}
