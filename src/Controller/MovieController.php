<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    public function index()
    {
        $movies = [
            1 => [
                'id' => 1,
                'title' => 'alien',
                'date'  => 1979
            ],
            2 => [
                'id' => 2,
                'title' => 'Les Huit salopards',
                'date' => 2015
            ]
        ];

        return $this->json($movies);
    }
}
