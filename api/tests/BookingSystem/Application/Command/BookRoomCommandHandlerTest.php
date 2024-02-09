<?php

declare(strict_types=1);

namespace Tests\BookingSystem\Application\Command;

use BookingSystem\Application\Command\BookRoomCommand;
use BookingSystem\Application\Command\BookRoomCommandHandler;
use BookingSystem\DomainModel\Booking;
use BookingSystem\DomainModel\BookingRepository;
use BookingSystem\DomainModel\InvalidArrivalDate;
use BookingSystem\DomainModel\InvalidClientIdProvided;
use BookingSystem\DomainModel\InvalidRoomNameProvided;
use BookingSystem\DomainModel\RoomAlreadyBooked;
use BookingSystem\Infrastructure\InMemoryBookingRepository;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

final class BookRoomCommandHandlerTest extends TestCase
{
    private const VALID_ROOM_NAME = '123';
    private const INVALID_ROOM_NAME = '';

    private const VALID_CLIENT_ID = 1;

    private InMemoryBookingRepository $bookingRepository;
    private BookRoomCommandHandler $commandHandler;

    protected function setUp(): void
    {
        $this->bookingRepository = new InMemoryBookingRepository();
        $this->commandHandler = new BookRoomCommandHandler($this->bookingRepository);
    }

    #[Test]
    #[DataProvider('invalidClientIds')]
    public function givenABookingRequestWhenTheClientIdIsInvalidThenAnExceptionShouldBeThrown(int $invalidClientId): void
    {
        $this->expectException(InvalidClientIdProvided::class);

        $clientId = $invalidClientId;
        $roomName = self::VALID_ROOM_NAME;
        $arrivalDate = new \DateTimeImmutable();
        $departureDate = new \DateTimeImmutable();

        $command = new BookRoomCommand(
            $clientId,
            $roomName,
            $arrivalDate,
            $departureDate
        );

        $this->commandHandler->__invoke($command);
    }

    #[Test]
    public function givenABookingRequestWhenTheRoomNameIsInvalidThenAnExceptionShouldBeThrown(): void
    {
        $this->expectException(InvalidRoomNameProvided::class);

        $clientId = self::VALID_CLIENT_ID;
        $roomName = self::INVALID_ROOM_NAME;
        $arrivalDate = new \DateTimeImmutable();
        $departureDate = new \DateTimeImmutable();

        $command = new BookRoomCommand(
            $clientId,
            $roomName,
            $arrivalDate,
            $departureDate
        );
        $this->commandHandler->__invoke($command);
    }

    #[Test]
    public function givenABookingRequestWhenTheArrivalDateIsInvalidThenAnExceptionShouldBeThrown(): void
    {
        $this->expectException(InvalidArrivalDate::class);

        $clientId = self::VALID_CLIENT_ID;
        $roomName = self::VALID_ROOM_NAME;
        $departureDate = Carbon::now()->addWeek();
        $arrivalDate = Carbon::now()->addMonth();

        $command = new BookRoomCommand(
            $clientId,
            $roomName,
            $arrivalDate,
            $departureDate
        );

        $this->commandHandler->__invoke($command);
    }

    #[Test]
    #[DataProvider('bookingDates')]
    public function givenARoomNameFromABookingRequestWhenThereIsAnExistingBookingAnExceptionShouldBeThrown(
        \DateTimeInterface $existingArrivalDate,
        \DateTimeInterface $existingDepartureDate,
        \DateTimeInterface $requestedArrivalDate,
        \DateTimeInterface $requestedDepartureDate
    ): void
    {
        $this->expectException(RoomAlreadyBooked::class);

        $clientId = self::VALID_CLIENT_ID;
        $roomName = self::VALID_ROOM_NAME;

        $this->bookingRepository->add(
            new Booking(Uuid::uuid4(), $clientId, $roomName, $existingArrivalDate, $existingDepartureDate)
        );

        $command = new BookRoomCommand(
            $clientId,
            $roomName,
            $requestedArrivalDate,
            $requestedDepartureDate,
        );

        $this->commandHandler->__invoke($command);
    }

    public static function bookingDates(): array
    {
        return [
            [
                Carbon::now()->addWeek(), // $existingArrivalDate
                Carbon::now()->addWeeks(2), // $existingDepartureDate
                Carbon::now()->addWeek(), // $requestedArrivalDate
                Carbon::now()->addWeeks(2) // $requestedDepartureDate
            ],
            [
                Carbon::now()->addWeek(), // $existingArrivalDate
                Carbon::now()->addWeeks(2), // $existingDepartureDate
                Carbon::now()->addWeek()->addDays(2), // $requestedArrivalDate
                Carbon::now()->addWeeks(3) // $requestedDepartureDate
            ],
            [
                Carbon::now()->addWeeks(), // $existingArrivalDate
                Carbon::now()->addWeeks(2), // $existingDepartureDate
                Carbon::now()->addDays(2), // $requestedArrivalDate
                Carbon::now()->addWeek() // $requestedDepartureDate
            ],
        ];
    }

    public static function invalidClientIds(): Generator
    {
        foreach (range(0, 10) as $invalidClientId) {
            yield [$invalidClientId * (-self::VALID_CLIENT_ID)];
        }
    }

    #[Test]
    public function givenTheCorrectDataForABookingWhenItIsRequestedThenItShouldBeRegisteredSuccessfully(): void
    {
        ($this->commandHandler)(
            new BookRoomCommand(
                self::VALID_CLIENT_ID,
                self::VALID_ROOM_NAME,
                Carbon::now(),
                Carbon::now()->addWeek()
            )
        );

        $this->assertCount(1, $this->bookingRepository->all());
    }
}
