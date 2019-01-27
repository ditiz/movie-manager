<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Movie;
use App\Entity\MovieTosee;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieSeeRepository")
 */
class MovieSee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="Movie", mappedBy="id")
     */
    private $movie_id;

    /**
     * @ORM\Column(type="string", length=64)
     * @ORM\OneToOne(targetEntity="Movie", mappedBy="imdbID")
     * @ORM\OneToOne(targetEntity="MovieToSee", mappedBy="imdbID")
     */
    private $imdbID;

    /**
     * @ORM\Column(type="boolean")
     */
    private $see;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImdbId(): ?int
    {
        return $this->imdbID;
    }

    public function setImdbId(string $imdbID): self
    {
        $this->imdbID = $imdbID;

        return $this;
    }

    public function getMovieId(): ?int
    {
        return $this->movie_id;
    }

    public function setMovieId(int $movie_id): self
    {
        $this->movie_id = $movie_id;

        return $this;
    }

    public function getSee(): ?bool
    {
        return $this->see;
    }

    public function setSee(bool $see): self
    {
        $this->see = $see;

        return $this;
    }
}
