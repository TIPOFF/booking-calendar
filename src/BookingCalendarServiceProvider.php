<?php

declare(strict_types=1);

namespace Tipoff\BookingCalendar;

use Tipoff\BookingCalendar\Models\BookingCalendar;
use Tipoff\BookingCalendar\Policies\BookingCalendarPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;


class BookingCalendarServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                BookingCalendar::class => BookingCalendarPolicy::class,
            ])
            ->name('remote-monitoring')
            ->hasConfigFile();
    }
}