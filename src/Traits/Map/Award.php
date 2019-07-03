<?php

namespace App\Traits\Map;

use App\Entity\Award as AwardEntity;

trait Award
{
    /**
     * Map for awards
     *
     * @param array $awards
     * @return array
     */
    private function mapCollectionAward(array $awards): array
    {
        $result = [];

        foreach ($awards as $award) {
            $result[] = $this->mapAward($award);
        }

        return $result;
    }

    /**
     * Map for award
     *
     * @param AwardEntity $award
     * @return array
     */
    private function mapAward(AwardEntity $award): array
    {
        return [
            'id' => $award->getId(),
            'name' => $award->getName(),
            'desc' => $award->getDescription(),
            'nat' => $award->getIsInternational() ? 'Yes' : 'No',
            'country' => $award->getCountry()->getCode(),
        ];
    }
}