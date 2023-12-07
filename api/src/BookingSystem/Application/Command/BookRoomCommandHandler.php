<?php

declare(strict_types=1);

namespace BookingSystem\Application\Command;

use BookingSystem\DomainModel\InvalidClientIdProvided;
use BookingSystem\DomainModel\InvalidRoomNameProvided;

final class BookRoomCommandHandler
{
    public function __invoke(BookRoomCommand $command): void
    {
        $this->assertClientIdIsValid($command->clientId);
        $this->assertRoomNameIsValid($command->roomName);

    }

    public function assertClientIdIsValid(int $clientId): void
    {
        if ($clientId <= 0) {
            throw new InvalidClientIdProvided();
        }
    }

    public function assertRoomNameIsValid(string $roomName): void
    {
        if ('' === $roomName) {
            throw new InvalidRoomNameProvided();
        }
    }
}
