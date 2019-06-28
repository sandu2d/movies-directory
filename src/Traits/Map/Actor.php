<?php

namespace App\Traits\Map;

use App\Entity\Actor as ActorEntity;

trait Actor
{
    /**
     * Map for actors
     *
     * @param array $actors
     * @return array
     */
    private function mapCollectionActor(array $actors): array
    {
        $result = [];

        foreach ($actors as $actor) {
            $result[] = $this->mapActor($actor);
        }

        return $result;
    }

    /**
     * Map for actor
     *
     * @param ActorEntity $actor
     * @return array
     */
    private function mapActor(ActorEntity $actor): array
    {
        return [
            'id' => $actor->getId(),
            'firstName' => $actor->getFirstName(),
            'lastName' => $actor->getLastName(),
            'fullName' => $actor->getFirstName() . ' ' . $actor->getLastName(),
            'nationality' => $actor->getNationality()->getNationality(),
        ];
    }
}