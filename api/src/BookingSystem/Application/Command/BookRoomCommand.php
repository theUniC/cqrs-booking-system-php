<?php

declare(strict_types=1);

namespace BookingSystem\Application\Command;

final readonly class BookRoomCommand
{
    public function __construct(
        public int $clientId,
        public string $roomName,
        public \DateTimeInterface $arrivalDate,
        public \DateTimeInterface $departureDate,
    ) {
    }
}
