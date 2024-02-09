<?php

declare(strict_types=1);

namespace BookingSystem\Application\Command;

use BookingSystem\DomainModel\InvalidRoomId;
use BookingSystem\DomainModel\InvalidRoomNameProvided;
use Ramsey\Uuid\Uuid;

final class RoomCommandHandler
{
    public function __invoke(
        RoomCommand $command
    ) {
        $this->assertValidRoomId($command->roomId);
        $this->assertValidRoomName($command->roomName);
    }

    public function assertValidRoomId(string $roomId): void
    {
        if (false === Uuid::isValid($roomId)) {
            throw new InvalidRoomId();
        }
    }

    public function assertValidRoomName(string $roomName): void
    {
        if ($roomName === '') {
            throw new InvalidRoomNameProvided();
        }
    }
}
