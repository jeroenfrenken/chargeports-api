<?php

namespace App\Entity;

use App\Repository\ChargerConnectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups("read")
     */
    private $connectionTypeId;

    /**
     * @ORM\Column(type="integer")
     * @Groups("read")
     */
    private $statusTypeId;

    /**
     * @ORM\Column(type="integer")
     * @Groups("read")
     */
    private $levelId;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Groups("read")
     */
    private $powerKw;

    /**
     * @ORM\Column(type="integer")
     * @Groups("read")
     */
    private $currentTypeId;

    /**
     * @ORM\Column(type="integer")
     * @Groups("read")
     */
    private $quantity;

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

    public function getConnectionTypeId(): ?int
    {
        return $this->connectionTypeId;
    }

    public function setConnectionTypeId(int $ConnectionTypeId): self
    {
        $this->connectionTypeId = $ConnectionTypeId;

        return $this;
    }

    public function getStatusTypeId(): ?int
    {
        return $this->statusTypeId;
    }

    public function setStatusTypeId(int $StatusTypeId): self
    {
        $this->statusTypeId = $StatusTypeId;

        return $this;
    }

    public function getLevelId(): ?int
    {
        return $this->levelId;
    }

    public function setLevelId(int $LevelId): self
    {
        $this->levelId = $LevelId;

        return $this;
    }

    public function getPowerKw(): ?string
    {
        return $this->powerKw;
    }

    public function setPowerKw(string $PowerKw): self
    {
        $this->powerKw = $PowerKw;

        return $this;
    }

    public function getCurrentTypeId(): ?int
    {
        return $this->currentTypeId;
    }

    public function setCurrentTypeId(int $CurrentTypeId): self
    {
        $this->currentTypeId = $CurrentTypeId;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->quantity = $Quantity;

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
