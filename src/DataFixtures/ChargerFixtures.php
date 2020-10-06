<?php

namespace App\DataFixtures;

use App\Entity\Charger;
use App\Entity\ChargerConnection;
use App\Util\GenerateUtil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ChargerFixtures extends Fixture
{
    private function _getChargersFromApi()
    {
        $chargers = file_get_contents("https://api.openchargemap.io/v3/poi/?output=json&verbose=false&maxresults=5000&compact=true&countrycode=NL&key=API_KEY_HERE");

        return json_decode($chargers, true);
    }

    public function load(ObjectManager $manager)
    {
        $count = 0;
        foreach ($this->_getChargersFromApi() as $charger) {
            if (isset($charger['AddressInfo'])) {
                $lat = $charger['AddressInfo']['Latitude'];
                $long = $charger['AddressInfo']['Longitude'];

                $c = (new Charger())
                    ->setIsAvailable(true)
                    ->setLatitude($lat)
                    ->setUuid(GenerateUtil::generateUuid())
                    ->setLongitude($long)
                    ->setName($charger['AddressInfo']['Title']);

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
