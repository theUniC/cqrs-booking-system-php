<?php

declare(strict_types=1);

namespace Tests\BookingSystem\Application\Command;

use BookingSystem\Application\Command\BookRoomCommand;
use BookingSystem\Application\Command\BookRoomCommandHandler;
use BookingSystem\DomainModel\InvalidClientIdProvided;
use BookingSystem\DomainModel\InvalidRoomNameProvided;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class BookRoomCommandHandlerTest extends TestCase
{
    private const VALID_ROOM_NAME       = '123';
    private const INVALID_ROOM_NAME     = '';

    private const VALID_CLIENT_ID       = 1;

    #[Test]
    #[DataProvider('invalidClientIds')]
    public function givenABookingRequestWhenTheClientIdIsInvalidThenAnExceptionShouldBeThrown(int $invalidClientId): void
    {
        $this->expectException(InvalidClientIdProvided::class);

        $clientId = $invalidClientId;
        $roomName = self::VALID_ROOM_NAME;
        $arrivalDate = new \DateTimeImmutable();
        $departureDate = new \DateTimeImmutable();

        $commandHandler = new BookRoomCommandHandler();
        $command = new BookRoomCommand(
            $clientId,
            $roomName,
            $arrivalDate,
            $departureDate
        );
        $commandHandler($command);
    }

    #[Test]
    public function givenABookingRequestWhenTheRoomNameIsInvalidThenAnExceptionShouldBeThrown(): void
    {
        $this->expectException(InvalidRoomNameProvided::class);

        $clientId = self::VALID_CLIENT_ID;
        $roomName = self::INVALID_ROOM_NAME;
        $arrivalDate = new \DateTimeImmutable();
        $departureDate = new \DateTimeImmutable();

        $commandHandler = new BookRoomCommandHandler();
        $command = new BookRoomCommand(
            $clientId,
            $roomName,
            $arrivalDate,
            $departureDate
        );
        $commandHandler($command);
    }

    public static function invalidClientIds(): Generator
    {
        foreach (range(0, 10) as $invalidClientId) {
            yield [$invalidClientId * (-self::VALID_CLIENT_ID)];
        }
    }
}
