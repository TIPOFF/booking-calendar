<?php

namespace Tipoff\BookingCalendar\Commands;

use Illuminate\Console\Command;

class BookingCalendarCommand extends Command
{
    public $signature = 'booking-calendar';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
