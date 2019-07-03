<?php

namespace App\Traits\Map;

use App\Entity\Movie as MovieEntity;

trait Movie
{
    /**
     * Map for movies
     *
     * @param array $movies
     * @return array
     */
    private function mapCollectionMovie(array $movies): array
    {
        $result = [];

        foreach ($movies as $movie) {
            $result[] = $this->mapMovie($movie);
        }

        return $result;
    }

    /**
     * Map for movie
     *
     * @param MovieEntity $movie
     * @return array
     */
    private function mapMovie(MovieEntity $movie): array
    {
        return [
            'id' => $movie->getId(),
            'name' => $movie->getName(),
            'description' => $movie->getDescription(),
            'year' => $movie->getYear(),
            'imdb_rate' => $movie->getImdbRate(),
            'box_office' => $movie->getBoxOffice(),
            'poster' => $movie->getPoster(),
            'country' => $movie->getCountry()->getCode(),
            'language' => $movie->getLanguage()->getName(),
        ];
    }
}