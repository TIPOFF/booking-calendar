<?php

declare(strict_types=1);

namespace Tipoff\BookingCalendar;

use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;


class BookingCalendarServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->name('booking-calendar')
            ->hasConfigFile();
    }
}
