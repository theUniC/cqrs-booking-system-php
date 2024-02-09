<?php

declare(strict_types=1);

namespace BookingSystem\Application\Command;

use BookingSystem\DomainModel\InvalidFloorNumber;
use BookingSystem\DomainModel\InvalidRoomId;
use BookingSystem\DomainModel\InvalidRoomNameProvided;
use Ramsey\Uuid\Uuid;

final class RoomCommandHandler
{
    public function __invoke(RoomCommand $command): void
    {
        $this->assertValidRoomId($command->roomId);
        $this->assertValidRoomName($command->roomName);
        $this->assertValidFloorNumber($command->floor);
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

    public function assertValidFloorNumber(int $floor): void
    {
        if ($floor <= 0) {
            throw new InvalidFloorNumber();
        }
    }
}
