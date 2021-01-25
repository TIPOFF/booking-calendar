<?php

namespace Tipoff\BookingCalendar;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\BookingCalendar\BookingCalendar
 */
class BookingCalendarFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'booking-calendar';
    }
}
