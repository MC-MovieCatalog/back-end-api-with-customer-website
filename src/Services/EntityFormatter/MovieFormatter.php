<?php

namespace App\Services\EntityFormatter;

use App\Entity\Movie;
use App\Services\UtilitiesService\SurveyData;
use App\Services\UtilitiesService\ConvertDate;

class MovieFormatter
{    
    private $convertDate;
    private $surveyData;

    public function __construct(
        ConvertDate $convertDate,
        SurveyData $surveyData
    )
    {
        $this->convertDate = $convertDate;
        $this->surveyData = $surveyData;
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
            'trailer' => (string) $movie->getTrailer(),
            'slug' => (string) $movie->getSlug()
        ];
    }

    /**
     * Default movie model for any transformation.
     *
     * @param Movie $movie
     */
    public function transform(Movie $movie)
    {
        return $this->managMovie($movie);
    }

    /**
     * This function is only used to transform the indicated movies into the correct format. 
     * [{element: element}, {element: element}]
     *
     * @return array | movies
     */
    public function transformAll($movies)
    {
        if ($movies === "undefined") {
            return "undefined";
        } else {
            if ($this->surveyData->isNotNullData($movies) === true) {
                $moviesArray = [];
    
                foreach ($movies as $movie) {
                    $moviesArray[] = $this->transform($movie);
                }
    
                return $moviesArray;
            } else {
                return "Aucun film dans notre base pour le moment";
            }
        }
    }

}
