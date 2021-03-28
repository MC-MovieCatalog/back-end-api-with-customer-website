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
     * @ORM\Column(type="string", length=255)
     */
    private $onGoing;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="onGoings")
     */
    private $movie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOngoing(): ?string
    {
        return $this->onGoing;
    }

    public function setOngoing(string $onGoing): self
    {
        $this->onGoing = $onGoing;

        return $this;
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
}
