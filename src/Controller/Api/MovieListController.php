<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Movie;
use App\Entity\MovieSee;
use App\Entity\MovieToSee;

class MovieListController extends AbstractController
{
	public function index()
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();

        return $this->json($movies);
    }

    public function getOneByImdbID($imdbID)
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findBy(['imdbID' => $imdbID]);

        return $this->json($movies);
    }

    public function getOneById($id)
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->find($id);

        return $this->json($movies);
    }
}