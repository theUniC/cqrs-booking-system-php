<?php

declare(strict_types=1);

namespace BookingSystem\Application\Command;

use BookingSystem\DomainModel\InvalidFloorNumber;
use BookingSystem\DomainModel\InvalidRoomId;
use BookingSystem\DomainModel\InvalidRoomNameProvided;
use BookingSystem\DomainModel\InvalidRoomNumber;
use Ramsey\Uuid\Uuid;

final class RoomCommandHandler
{
    public function __invoke(RoomCommand $command): void
    {
        $this->assertValidRoomId($command->roomId);
        $this->assertValidRoomName($command->roomName);
        $this->assertValidFloorNumber($command->floor);
        $this->assertValidRoomNumber($command->floor, $command->roomNumber);
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

    public function assertValidRoomNumber(int $floor, int $roomNumber): void
    {
        if ($roomNumber <= 0) {
            throw new InvalidRoomNumber();
        }

        if ($roomNumber <= $floor * 100) {
            throw new InvalidRoomNumber();
        }
    }
}
