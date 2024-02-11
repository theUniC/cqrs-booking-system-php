<?php

declare(strict_types=1);

namespace Tests\BookingSystem\Application\Command;

use BookingSystem\Application\Command\RoomCommand;
use BookingSystem\Application\Command\RoomCommandHandler;
use BookingSystem\DomainModel\InvalidFloorNumber;
use BookingSystem\DomainModel\InvalidRoomId;
use BookingSystem\DomainModel\InvalidRoomNameProvided;
use BookingSystem\DomainModel\InvalidRoomNumber;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateRoomCommandHandlerTest extends TestCase
{
    public const INVALID_ROOM_ID = 'abc';
    public const INVALID_ROOM_NAME = '';
    public const INVALID_FLOOR_NAME = 0;
    public const INVALID_ROOM_NUMBER = -10;

    #[Test]
    public function givenAnInvalidRoomIdThenItShouldThrowAnException(): void
    {
        $this->expectException(InvalidRoomId::class);

        $roomId = self::INVALID_ROOM_ID;
        $roomName = 'room1';
        $floor = 2;
        $roomNumber = 202;

        $roomCommand = new RoomCommand($roomId, $roomName, $floor, $roomNumber);
        (new RoomCommandHandler())->__invoke($roomCommand);
    }

    #[Test]
    public function givenAnInvalidRoomNameThenItShouldThrowAnException(): void
    {
        $this->expectException(InvalidRoomNameProvided::class);

        $roomId = Uuid::uuid4()->toString();
        $roomName = self::INVALID_ROOM_NAME;
        $floor = 2;
        $roomNumber = 202;

        $roomCommand = new RoomCommand($roomId, $roomName, $floor, $roomNumber);
        (new RoomCommandHandler())->__invoke($roomCommand);
    }

    #[Test]
    public function givenAnInvalidFloorThenItShouldReturnAnException(): void
    {
        $this->expectException(InvalidFloorNumber::class);

        $roomId = Uuid::uuid4()->toString();
        $roomName = 'room1';
        $floor = self::INVALID_FLOOR_NAME;
        $roomNumber = 202;

        $roomCommand = new RoomCommand($roomId, $roomName, $floor, $roomNumber);
        (new RoomCommandHandler())->__invoke($roomCommand);
    }

    #[Test]
    public function givenAnInvalidRoomNumberThenItShouldReturnAnException(): void
    {
        $this->expectException(InvalidRoomNumber::class);

        $roomId = Uuid::uuid4()->toString();
        $roomName = 'room1';
        $floor = 2;
        $roomNumber = self::INVALID_ROOM_NUMBER;

        $roomCommand = new RoomCommand($roomId, $roomName, $floor, $roomNumber);
        (new RoomCommandHandler())->__invoke($roomCommand);
    }
}
