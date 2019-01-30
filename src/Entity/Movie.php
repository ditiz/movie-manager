<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="MovieSee", mappedBy="movie_id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $Rated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Released;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $director;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $writer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $actors;

    /**
     * @ORM\Column(type="text")
     */
    private $plot;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $languages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $awards;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $poster;

    /**
     * @ORM\Column(type="array")
     */
    private $rating = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $metascore;

    /**
     * @ORM\Column(type="float")
     */
    private $imdbrating;

    /**
     * @ORM\Column(type="float")
     */
    private $imdbVotes;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\OneToMany(targetEntity="MovieSee", mappedBy="imdbID")
     */
    private $imdbID;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $DVD;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $boxoffice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $production;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $runtime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getRated(): ?string
    {
        return $this->Rated;
    }

    public function setRated(string $Rated): self
    {
        $this->Rated = $Rated;

        return $this;
    }

    public function getReleased(): ?string
    {
        return $this->Released;
    }

    public function setReleased(?string $Released): self
    {
        $this->Released = $Released;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getWriter(): ?string
    {
        return $this->writer;
    }

    public function setWriter(?string $writer): self
    {
        $this->writer = $writer;

        return $this;
    }

    public function getActors(): ?string
    {
        return $this->actors;
    }

    public function setActors(string $actors): self
    {
        $this->actors = $actors;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(?string $plot): self
    {
        $this->plot = $plot;

        return $this;
    }

    public function getLanguages(): ?string
    {
        return $this->languages;
    }

    public function setLanguages(string $languages): self
    {
        $this->languages = $languages;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAwards(): ?string
    {
        return $this->awards;
    }

    public function setAwards(string $awards): self
    {
        $this->awards = $awards;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getRating(): ?array
    {
        return $this->rating;
    }

    public function setRating(array $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getMetascore(): ?int
    {
        return $this->metascore;
    }

    public function setMetascore(int $metascore): self
    {
        $this->metascore = $metascore;

        return $this;
    }

    public function getImdbrating(): ?float
    {
        return $this->imdbrating;
    }

    public function setImdbrating(float $imdbrating): self
    {
        $this->imdbrating = $imdbrating;

        return $this;
    }

    public function getImdbVotes(): ?float
    {
        return $this->imdbVotes;
    }

    public function setImdbVotes(float $imdbVotes): self
    {
        $this->imdbVotes = $imdbVotes;

        return $this;
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

    public function getDVD(): string
    {
        return $this->DVD;
    }

    public function setDVD(string $DVD): self
    {
        $this->DVD = $DVD;

        return $this;
    }

    public function getBoxoffice(): ?string
    {
        return $this->boxoffice;
    }

    public function setBoxoffice(string $boxoffice): self
    {
        $this->boxoffice = $boxoffice;

        return $this;
    }

    public function getProduction(): ?string
    {
        return $this->production;
    }

    public function setProduction(string $production): self
    {
        $this->production = $production;

        return $this;
    }

    public function getRuntime(): ?string
    {
        return $this->runtime;
    }

    public function setRuntime(string $runtime): self
    {
        $this->runtime = $runtime;

        return $this;
    }
}
