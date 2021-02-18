<?php

namespace App\Entity;

use App\Repository\OngoingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OngoingRepository::class)
 * @ORM\Table(name="`ongoings`")
 */
class Ongoing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="ongoing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ongoing;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getOngoing(): ?string
    {
        return $this->ongoing;
    }

    public function setOngoing(string $ongoing): self
    {
        $this->ongoing = $ongoing;

        return $this;
    }
}
