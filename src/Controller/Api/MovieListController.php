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
            ->findOneBy(['imdbID' => $imdbID]);

        return $this->json($movies);
    }

    public function getOneById($id)
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findOne($id);

        return $this->json($movies);
    }

    public function toSee() {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieToSee();

        return $this->json($movies);
    }

    public function see() {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findMovieSee();

        return $this->json($movies);
    }

    public function lastToSeeAndSee() {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findLastMovieToSeeAndSee();

        return $this->json($movies);
    }
}