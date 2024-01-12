<?php

declare(strict_types=1);

namespace BookingSystem\DomainModel;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Booking
{
    public function __construct(
        private UuidInterface $id,
        private int $clientId,
        private string $roomName,
        private \DateTimeInterface $arrivalDate,
        private \DateTimeInterface $departureDate
    ) {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getRoomName(): string
    {
        return $this->roomName;
    }

    public function getArrivalDate(): \DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function getDepartureDate(): \DateTimeInterface
    {
        return $this->departureDate;
    }
}
