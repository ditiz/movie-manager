<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieToSeeRepository")
 */
class MovieToSee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=54)
     */
    private $imdbID;

    /**
     * @ORM\Column(type="boolean")
     */
    private $too_see;

    /**
     * @ORM\Column(type="integer")
     */
    private $movie_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImdbID(): ?string
    {
        return $this->imdbID;
    }

    public function setImdbID(string $imdbID): self
    {
        $this->imdbID = $imdbID;

        return $this;
    }

    public function getTooSee(): ?bool
    {
        return $this->too_see;
    }

    public function setTooSee(bool $too_see): self
    {
        $this->too_see = $too_see;

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
}
