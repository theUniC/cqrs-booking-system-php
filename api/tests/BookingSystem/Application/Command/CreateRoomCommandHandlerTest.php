<?php

declare(strict_types=1);

namespace Tests\BookingSystem\Application\Command;

use BookingSystem\Application\Command\RoomCommand;
use BookingSystem\Application\Command\RoomCommandHandler;
use BookingSystem\DomainModel\InvalidRoomId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CreateRoomCommandHandlerTest extends TestCase
{
    public const INVALID_ROOM_ID = 'abc';

    #[Test]
    public function givenAnInvalidRoomIdThenItShouldThrowAnException(): void
    {
        $this->expectException(InvalidRoomId::class);

        $roomCommand = new RoomCommand(self::INVALID_ROOM_ID);
        (new RoomCommandHandler())->__invoke($roomCommand);
    }



}
