<?php

declare(strict_types=1);

namespace BookingSystem\Application\Command;

use DateTimeImmutable;

final readonly class BookRoomCommand
{
    public function __construct(
        public int $clientId,
        public string $roomName,
        public DateTimeImmutable $arrivalDate,
        public DateTimeImmutable $departureDate,
    ) {
    }
}
