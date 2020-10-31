<?php

namespace App\Model;

use App\Entity\ChargerConnection;
use DateTime;
use DateTimeInterface;

class ReservationDTO
{
    private DateTimeInterface $startTime;
    private DateTimeInterface $endTime;
    private ?ChargerConnection $chargerConnection = null;

    public function __construct()
    {
        $this->startTime = new DateTime();
        $this->endTime = new DateTime();
    }

    public function getStartTime(): DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(DateTimeInterface $startTime): ReservationDTO
    {
        $this->startTime = $startTime;
        return $this;
    }

    public function getEndTime(): DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(DateTimeInterface $endTime): ReservationDTO
    {
        $this->endTime = $endTime;
        return $this;
    }

    /**
     * @return ChargerConnection|null
     */
    public function getChargerConnection(): ?ChargerConnection
    {
        return $this->chargerConnection;
    }

    /**
     * @param ChargerConnection|null $chargerConnection
     * @return ReservationDTO
     */
    public function setChargerConnection(?ChargerConnection $chargerConnection): ReservationDTO
    {
        $this->chargerConnection = $chargerConnection;
        return $this;
    }
}
