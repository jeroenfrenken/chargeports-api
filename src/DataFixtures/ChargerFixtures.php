<?php

namespace App\DataFixtures;

use App\Entity\Charger;
use App\Entity\ChargerConnection;
use App\Util\GenerateUtil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/*
 * Solution for running the migrations
 *
 * This is bad practice !!
 */
ini_set('memory_limit', '-1');

class ChargerFixtures extends Fixture
{
    private function _getChargersFromApi()
    {
        $chargers = file_get_contents(__DIR__ .'/../Data/Chargers.json');

        return json_decode($chargers, true);
    }

    public function load(ObjectManager $manager)
    {
        $count = 0;
        foreach ($this->_getChargersFromApi() as $charger) {
            if (
                isset($charger['AddressInfo']) &&
                isset($charger['AddressInfo']['Title'])
            ) {
                $lat = $charger['AddressInfo']['Latitude'];
                $long = $charger['AddressInfo']['Longitude'];

                $c = (new Charger())
                    ->setIsAvailable(true)
                    ->setLatitude($lat)
                    ->setUuid(GenerateUtil::generateUuid())
                    ->setLongitude($long)
                    ->setName($charger['AddressInfo']['Title'])
                    ->setAddressLine($charger['AddressInfo']['AddressLine1'] ?? "")
                    ->setTown($charger['AddressInfo']['Town'] ?? "")
                    ->setStateOrProvince($charger['AddressInfo']['StateOrProvince'] ?? "")
                    ->setPostcode($charger['AddressInfo']['Postcode'] ?? "");

                $manager->persist($c);

                if (isset($charger['Connections'])) {
                    foreach ($charger['Connections'] as $connection) {
                        $connectionCharger = (new ChargerConnection())
                            ->setCharger($c)
                            ->setConnectionTypeId($connection['ConnectionTypeID'] ?? 0)
                            ->setStatusTypeId($connection['StatusTypeID'] ?? 0)
                            ->setLevelId($connection['LevelID'] ?? 0)
                            ->setPowerKw($connection['PowerKW'] ?? "0.0")
                            ->setCurrentTypeId($connection['CurrentTypeID'] ?? 0)
                            ->setQuantity($connection['Quantity'] ?? 0);

                        $manager->persist($connectionCharger);
                    }
                }
            }

            if ($count > 1000) {
                $manager->flush();
                $count = 0;
            }
        }

        if ($count < 1000) {
            $manager->flush();
        }
    }
}
