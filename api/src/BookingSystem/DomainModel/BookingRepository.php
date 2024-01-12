<?php

declare(strict_types=1);

namespace BookingSystem\DomainModel;

interface BookingRepository
{
    public function add(Booking $booking): void;
    /** @return Booking[] */
    public function all(): array;
}
