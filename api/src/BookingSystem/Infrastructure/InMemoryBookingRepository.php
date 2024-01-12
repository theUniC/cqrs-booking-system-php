<?php

declare(strict_types=1);

namespace BookingSystem\Infrastructure;

use BookingSystem\DomainModel\Booking;
use BookingSystem\DomainModel\BookingRepository;

final class InMemoryBookingRepository implements BookingRepository
{
    /** @var Booking[] */
    private array $bookings = [];

    public function add(Booking $booking): void
    {
        $this->bookings[] = $booking;
    }

    public function all(): array
    {
        return $this->bookings;
    }
}
