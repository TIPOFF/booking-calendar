<?php

declare(strict_types=1);

namespace Tipoff\BookingCalendar;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'booking-calendar');
        $this->mergeConfigFrom(__DIR__ . '/../config/booking-calendar.php', 'booking_calendar');

    /**
     *
     * @psalm-suppress UnusedParam
     */
        Nova::serving(function (ServingNova $event) {
            Nova::provideToScript([
                'fullCalendarLicenseKey' => config('booking_calendar.full_calendar_license_key'),
            ]);
        });
    }

    public function register()
    {
        Nova::tools([
            new BookingCalendar(),
        ]);
    }
}
