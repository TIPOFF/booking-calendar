<?php

namespace Tipoff\BookingCalendar;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\BookingCalendar\Commands\BookingCalendarCommand;

class BookingCalendarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('booking-calendar')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_booking_calendar_table')
            ->hasCommand(BookingCalendarCommand::class);
    }
}
