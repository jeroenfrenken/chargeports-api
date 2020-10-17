<?php
namespace App\Doctrine\Hydration;

use App\Entity\Charger;
use Doctrine\ORM\Internal\Hydration\ObjectHydrator;

class ChargerHydration extends ObjectHydrator
{
    protected function hydrateAllData()
    {
        $result = parent::hydrateAllData();

        return $this->toClassArray($result);
    }

    protected function toClassArray(array $result)
    {
        $returnArray = array();

        foreach ($result as $entity) {
            /** @var Charger $charger */
            $charger = $entity[0];

            $charger->setDistance($entity['distance']);
            $returnArray[] = $charger;
        }

        return $returnArray;
    }
}
