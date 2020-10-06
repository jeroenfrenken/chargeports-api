<?php

namespace App\Entity;

use App\Repository\ChargerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ChargerRepository::class)
 */
class Charger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("read")
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=6)
     * @Groups("read")
     */
    private $latitude;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=6)
     * @Groups("read")
     */
    private $longitude;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("read")
     */
    private $isAvailable;

    /**
     * @ORM\Column(type="guid")
     * @Groups("read")
     */
    private $uuid;

    /**
     * @ORM\OneToMany(targetEntity=ChargerConnection::class, mappedBy="charger", orphanRemoval=true)
     */
    private $chargerConnections;

    public function __construct()
    {
        $this->chargerConnections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return Collection|ChargerConnection[]
     */
    public function getChargerConnections(): Collection
    {
        return $this->chargerConnections;
    }

    public function addChargerConnection(ChargerConnection $chargerConnection): self
    {
        if (!$this->chargerConnections->contains($chargerConnection)) {
            $this->chargerConnections[] = $chargerConnection;
            $chargerConnection->setCharger($this);
        }

        return $this;
    }

    public function removeChargerConnection(ChargerConnection $chargerConnection): self
    {
        if ($this->chargerConnections->contains($chargerConnection)) {
            $this->chargerConnections->removeElement($chargerConnection);
            // set the owning side to null (unless already changed)
            if ($chargerConnection->getCharger() === $this) {
                $chargerConnection->setCharger(null);
            }
        }

        return $this;
    }
}
