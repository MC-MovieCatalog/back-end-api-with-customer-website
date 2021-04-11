<?php

namespace App\Repository\RepositoryFormatter;

use App\Entity\Movie;
use App\Services\ConvertDate;

class MovieFormatter
{    
    private $convertDate;

    public function __construct(
        ConvertDate $convertDate
    )
    {
        $this->convertDate = $convertDate;
    }

    /**
     * Transform movie
     *
     * @param Movie $movie
     * @return array
     */
    public function managMovie(Movie $movie)
    {
        return [
            'id' => (int) $movie->getId(),
            'duration' => (string) $movie->getDuration(),
            'link' => (string) $movie->getLink(),
            'description' => (string) $movie->getDescription(),
            'title' => (string) $movie->getTitle(),
            'price' => (float) $movie->getPrice(),
            'cover' => (string) $movie->getCover(),
            'createdAt' => (string) $this->convertDate->toDateTimeFr($movie->getCreatedAt()->format('Y-m-d H:i:s'), true),
            // 'createdAt' => $this->convertDate->toStrDateTimeFr($movie->getCreatedAt()->format('Y-m-d H:i:s'), false),
            'director' => (string) $movie->getDirector(),
            'trailor' => (string) $movie->getTrailer()
        ];
    }

}
