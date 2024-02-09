<?php

declare(strict_types=1);

namespace Tests\BookingSystem\Application\Command;

use BookingSystem\Application\Command\RoomCommand;
use BookingSystem\Application\Command\RoomCommandHandler;
use BookingSystem\DomainModel\InvalidRoomId;
use BookingSystem\DomainModel\InvalidRoomNameProvided;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateRoomCommandHandlerTest extends TestCase
{
    public const INVALID_ROOM_ID = 'abc';
    public const INVALID_ROOM_NAME = '';

    #[Test]
    public function givenAnInvalidRoomIdThenItShouldThrowAnException(): void
    {
        $this->expectException(InvalidRoomId::class);

        $roomId = self::INVALID_ROOM_ID;
        $roomName = 'room1';

        $roomCommand = new RoomCommand($roomId, $roomName);
        (new RoomCommandHandler())->__invoke($roomCommand);
    }

    #[Test]
    public function givenAnInvalidRoomNameThenItShouldThrowAnException(): void
    {
        $this->expectException(InvalidRoomNameProvided::class);

        $roomId = Uuid::uuid4()->toString();
        $roomName = self::INVALID_ROOM_NAME;

        $roomCommand = new RoomCommand($roomId, $roomName);
        (new RoomCommandHandler())->__invoke($roomCommand);
    }
}
