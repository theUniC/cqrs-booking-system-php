<?php

declare(strict_types=1);

namespace BookingSystem\Application\Command;

final readonly class RoomCommand
{
    public function __construct(
        public string $roomId,
        public string $roomName,
        public int $floor,
    ) {
    }
}
