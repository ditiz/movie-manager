<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;
use App\Entity\MovieToSee;
use App\Entity\MovieSee;

class MovieSeeController extends AbstractController
{
    public function index()
    {
        $movies = $this->getDoctrine()
            ->getRepository(moviesee::class)
            ->findAllMovieSeeJoinMovie(1);

        $watch_infos = $this->getWatchInfo($movies);

        return $this->render('movie/listMovie.html.twig', [
            'title' => 'Liste des films vu',
            'movies' => $movies,
            'watch_infos' => $watch_infos,
        ]);
    }

    private function getWatchInfo($movies) {
        $watch_infos = [];
        foreach ($movies as $movie) {
            $watch_infos['toSee'][$movie->getimdbID()] = $this->getDoctrine()
                ->getRepository(MovieToSee::class)
                ->findOneBy(['imdbID' =>$movie->getimdbID(), 'to_see' => 1]);

            $watch_infos['see'][$movie->getimdbID()] = $this->getDoctrine()
                ->getRepository(MovieSee::class)
                ->findOneBy(['imdbID' => $movie->getimdbID(), 'see' => 1]);
        }

        if ($watch_infos == []) {
            return false;
        }

        return $watch_infos;
    }
}
