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
     * @ORM\OneToOne(targetEntity="App\Entity\Movie", mappedBy="imdbID")
     * @ORM\OneToOne(targetEntity="App\Entity\MovieSee", mappedBy="imdbID")
     */
    private $imdbID;

    /**
     * @ORM\Column(type="boolean")
     */
    private $to_see;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="App\Entity\Movie", mappedBy="id")
     * @ORM\OneToOne(targetEntity="App\Entity\MovieSee", mappedBy="movie_id")
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
        return $this->to_see;
    }

    public function setTooSee(bool $to_see): self
    {
        $this->to_see = $to_see;

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

    public function getToSee(): ?bool
    {
        return $this->to_see;
    }

    public function setToSee(bool $to_see): self
    {
        $this->to_see = $to_see;

        return $this;
    }
}
