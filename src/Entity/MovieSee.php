<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $movie_id;

    /**
     * @ORM\Column(type="string", length=64)
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
        return $this->imdb_id;
    }

    public function setImdbId(int $imdb_id): self
    {
        $this->imdb_id = $imdb_id;

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
