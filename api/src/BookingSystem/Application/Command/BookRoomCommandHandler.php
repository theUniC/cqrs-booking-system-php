<?php

declare(strict_types=1);

namespace BookingSystem\Application\Command;

use BookingSystem\DomainModel\Booking;
use BookingSystem\DomainModel\InvalidArrivalDate;
use BookingSystem\DomainModel\InvalidClientIdProvided;
use BookingSystem\DomainModel\InvalidRoomNameProvided;
use BookingSystem\DomainModel\BookingRepository;
use BookingSystem\DomainModel\RoomAlreadyBooked;

final readonly class BookRoomCommandHandler
{
    public function __construct(
        private BookingRepository $bookingRepository
    ) {
    }

    public function __invoke(BookRoomCommand $command): void
    {
        $this->assertClientIdIsValid($command->clientId);
        $this->assertRoomNameIsValid($command->roomName);
        $this->assertArrivalDateIsNotBeyondDepartureDate($command->arrivalDate, $command->departureDate);
        $this->assertRoomIsAvailableForGivenDates($command->roomName, $command->arrivalDate, $command->departureDate);
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

    public function assertArrivalDateIsNotBeyondDepartureDate(\DateTimeInterface $arrivalDate, \DateTimeInterface $departureDate): void
    {
        if ($arrivalDate > $departureDate) {
            throw new InvalidArrivalDate();
        }
    }

    public function assertRoomIsAvailableForGivenDates(
        string $roomName,
        \DateTimeInterface $arrivalDate,
        \DateTimeInterface $departureDate
    ): void {
        $bookings = $this->bookingRepository->all();
        $bookingsMatchingDates = array_filter(
            $bookings,
            fn(Booking $booking) => $booking->getRoomName() === $roomName
                && (
                    $booking->getArrivalDate() >= $arrivalDate
                    || $booking->getDepartureDate() <= $departureDate
                )
        );

        if (count($bookingsMatchingDates) > 0) {
            throw new RoomAlreadyBooked();
        }
    }
}
