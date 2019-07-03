<?php

namespace App\Traits\Map;

use App\Entity\Director as DirectorEntity;

trait Director
{
    /**
     * Map for directors
     *
     * @param array $directors
     * @return array
     */
    private function mapCollectionDirector(array $directors): array
    {
        $result = [];

        foreach ($directors as $director) {
            $result[] = $this->mapDirector($director);
        }

        return $result;
    }

    /**
     * Map for director
     *
     * @param DirectorEntity $director
     * @return array
     */
    private function mapDirector(DirectorEntity $director): array
    {
        return [
            'id' => $director->getId(),
            'firstName' => $director->getFirstName(),
            'lastName' => $director->getLastName(),
            'fullName' => $director->getFirstName() . ' ' . $director->getLastName(),
            'nationality' => $director->getNationality()->getNationality(),
        ];
    }
}