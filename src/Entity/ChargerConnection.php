<?php

namespace App\Entity;

use App\Repository\ChargerConnectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChargerConnectionRepository::class)
 */
class ChargerConnection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Charger::class, inversedBy="chargerConnections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $charger;

    /**
     * @ORM\Column(type="integer")
     */
    private $ConnectionTypeId;

    /**
     * @ORM\Column(type="integer")
     */
    private $StatusTypeId;

    /**
     * @ORM\Column(type="integer")
     */
    private $LevelId;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $PowerKw;

    /**
     * @ORM\Column(type="integer")
     */
    private $CurrentTypeId;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantity;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="chargerConnection", orphanRemoval=true)
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharger(): ?Charger
    {
        return $this->charger;
    }

    public function setCharger(?Charger $charger): self
    {
        $this->charger = $charger;

        return $this;
    }

    /**
    {
    "ID": 7,
    "Title": "Avcon Connector",
    "FormalName": "Avcon SAE J1772-2001",
    "IsDiscontinued": true,
    "IsObsolete": false
    },
    {
    "ID": 4,
    "Title": "Blue Commando (2P+E)",
    "FormalName": null,
    "IsDiscontinued": null,
    "IsObsolete": null
    },
    {
    "ID": 3,
    "Title": "BS1363 3 Pin 13 Amp",
    "FormalName": "BS1363 / Type G",
    "IsDiscontinued": null,
    "IsObsolete": null
    },
    {
    "ID": 32,
    "Title": "CCS (Type 1)",
    "FormalName": "IEC 62196-3 Configuration EE",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 33,
    "Title": "CCS (Type 2)",
    "FormalName": "IEC 62196-3 Configuration FF",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 16,
    "Title": "CEE 3 Pin",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 17,
    "Title": "CEE 5 Pin",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 28,
    "Title": "CEE 7/4 - Schuko - Type F",
    "FormalName": "CEE 7/4",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 23,
    "Title": "CEE 7/5",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 18,
    "Title": "CEE+ 7 Pin",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 2,
    "Title": "CHAdeMO",
    "FormalName": "IEC 62196-3 Configuration AA",
    "IsDiscontinued": null,
    "IsObsolete": null
    },
    {
    "ID": 13,
    "Title": "Europlug 2-Pin (CEE 7/16)",
    "FormalName": "Europlug 2-Pin (CEE 7/16)",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 1038,
    "Title": "GB-T AC - GB/T 20234.2 (Socket)",
    "FormalName": "GB-T AC - GB/T 20234.2 (Socket)",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 1039,
    "Title": "GB-T AC - GB/T 20234.2 (Tethered Cable)",
    "FormalName": "GB-T AC - GB/T 20234.2 (Tethered Cable)",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 1040,
    "Title": "GB-T DC - GB/T 20234.3",
    "FormalName": "GB-T DC - GB/T 20234.3",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 34,
    "Title": "IEC 60309 3-pin",
    "FormalName": "IEC 60309 3-pin",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 35,
    "Title": "IEC 60309 5-pin",
    "FormalName": "IEC 60309 5-pin",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 5,
    "Title": "LP Inductive",
    "FormalName": "Large Paddle Inductive",
    "IsDiscontinued": true,
    "IsObsolete": true
    },
    {
    "ID": 10,
    "Title": "NEMA 14-30",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 11,
    "Title": "NEMA 14-50",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 22,
    "Title": "NEMA 5-15R",
    "FormalName": "NEMA 5-15R",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 9,
    "Title": "NEMA 5-20R",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 15,
    "Title": "NEMA 6-15",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 14,
    "Title": "NEMA 6-20",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 1042,
    "Title": "NEMA TT-30R",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 36,
    "Title": "SCAME Type 3A (Low Power)",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 26,
    "Title": "SCAME Type 3C (Schneider-Legrand)",
    "FormalName": "IEC 62196-2 Type 3",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 6,
    "Title": "SP Inductive",
    "FormalName": "Small Paddle Inductive",
    "IsDiscontinued": true,
    "IsObsolete": true
    },
    {
    "ID": 1037,
    "Title": "T13 - SEC1011 ( Swiss domestic 3-pin ) - Type J",
    "FormalName": "T13/ IEC Type J",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 30,
    "Title": "Tesla (Model S/X)",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 8,
    "Title": "Tesla (Roadster)",
    "FormalName": "Tesla Connector",
    "IsDiscontinued": true,
    "IsObsolete": false
    },
    {
    "ID": 31,
    "Title": "Tesla Battery Swap",
    "FormalName": "Tesla Battery Swap Station",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 27,
    "Title": "Tesla Supercharger",
    "FormalName": "Tesla Supercharger",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 1041,
    "Title": "Three Phase 5-Pin (AS/NZ 3123)",
    "FormalName": "AS/NZS 3123 Three Phase",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 1,
    "Title": "Type 1 (J1772)",
    "FormalName": "SAE J1772-2009",
    "IsDiscontinued": null,
    "IsObsolete": null
    },
    {
    "ID": 25,
    "Title": "Type 2 (Socket Only)",
    "FormalName": "IEC 62196-2 Type 2",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 1036,
    "Title": "Type 2 (Tethered Connector) ",
    "FormalName": "IEC 62196-2",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 29,
    "Title": "Type I (AS 3112)",
    "FormalName": "Type I/AS 3112/CPCS-CCC",
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 0,
    "Title": "Unknown",
    "FormalName": "Not Specified",
    "IsDiscontinued": null,
    "IsObsolete": null
    },
    {
    "ID": 24,
    "Title": "Wireless Charging",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    },
    {
    "ID": 21,
    "Title": "XLR Plug (4 pin)",
    "FormalName": null,
    "IsDiscontinued": false,
    "IsObsolete": false
    }
     */
    public function getConnectionTypeId(): ?int
    {
        return $this->ConnectionTypeId;
    }

    public function setConnectionTypeId(int $ConnectionTypeId): self
    {
        $this->ConnectionTypeId = $ConnectionTypeId;

        return $this;
    }

    /**
    {
    "ID": 0,
    "Title": "Unknown",
    "IsOperational": null,
    "IsUserSelectable": true
    },
    {
    "ID": 10,
    "Title": "Currently Available (Automated Status)",
    "IsOperational": true,
    "IsUserSelectable": false
    },
    {
    "ID": 20,
    "Title": "Currently In Use (Automated Status)",
    "IsOperational": true,
    "IsUserSelectable": false
    },
    {
    "ID": 30,
    "Title": "Temporarily Unavailable",
    "IsOperational": true,
    "IsUserSelectable": true
    },
    {
    "ID": 50,
    "Title": "Operational",
    "IsOperational": true,
    "IsUserSelectable": true
    },
    {
    "ID": 75,
    "Title": "Partly Operational (Mixed)",
    "IsOperational": true,
    "IsUserSelectable": true
    },
    {
    "ID": 100,
    "Title": "Not Operational",
    "IsOperational": false,
    "IsUserSelectable": true
    },
    {
    "ID": 150,
    "Title": "Planned For Future Date",
    "IsOperational": false,
    "IsUserSelectable": true
    },
    {
    "ID": 200,
    "Title": "Removed (Decommissioned)",
    "IsOperational": false,
    "IsUserSelectable": true
    },
    {
    "ID": 210,
    "Title": "Removed (Duplicate Listing)",
    "IsOperational": false,
    "IsUserSelectable": true
    }
     */
    public function getStatusTypeId(): ?int
    {
        return $this->StatusTypeId;
    }

    public function setStatusTypeId(int $StatusTypeId): self
    {
        $this->StatusTypeId = $StatusTypeId;

        return $this;
    }

    public function getLevelId(): ?int
    {
        return $this->LevelId;
    }

    public function setLevelId(int $LevelId): self
    {
        $this->LevelId = $LevelId;

        return $this;
    }

    public function getPowerKw(): ?string
    {
        return $this->PowerKw;
    }

    public function setPowerKw(string $PowerKw): self
    {
        $this->PowerKw = $PowerKw;

        return $this;
    }

    /**
    {
    "ID": 10,
    "Title": "AC (Single-Phase)",
    "Description": "Alternating Current - Single Phase"
    },
    {
    "ID": 20,
    "Title": "AC (Three-Phase)",
    "Description": "Alternating Current - Three Phase"
    },
    {
    "ID": 30,
    "Title": "DC",
    "Description": "Direct Current"
    }
     */
    public function getCurrentTypeId(): ?int
    {
        return $this->CurrentTypeId;
    }

    public function setCurrentTypeId(int $CurrentTypeId): self
    {
        $this->CurrentTypeId = $CurrentTypeId;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setChargerConnection($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getChargerConnection() === $this) {
                $reservation->setChargerConnection(null);
            }
        }

        return $this;
    }
}
