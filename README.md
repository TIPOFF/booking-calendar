# Laravel Nova Booking Calendar
Laravel Package for Nova Booking Calendar

## Installation

Install the package via composer:

```bash
composer require tipoff/booking-calendar
```

Register the tool in `NovaServiceProvider`:
```php
public function tools()
{
    return [
        // ...
        new \Tipoff\BookingCalendar\BookingCalendar,
    ];
}
```
