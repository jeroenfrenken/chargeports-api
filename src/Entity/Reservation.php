<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Groups("read")
     * @ORM\Column(type="datetime")
     */
    private $startTime;

    /**
     * @Groups("read")
     * @ORM\Column(type="datetime")
     */
    private $endTime;

    /**
     * @Groups("read")
     * @ORM\ManyToOne(targetEntity=ChargerConnection::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chargerConnection;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStartTime(): ?DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;
        return $this;
    }

    public function getEndTime(): ?DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getChargerConnection(): ?ChargerConnection
    {
        return $this->chargerConnection;
    }

    public function setChargerConnection(?ChargerConnection $chargerConnection): self
    {
        $this->chargerConnection = $chargerConnection;

        return $this;
    }
}
