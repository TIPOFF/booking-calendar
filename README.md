# Laravel Nova Booking Calendar
Booking calendar tool for Nova.

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

## Configuration

To use Full Calendar Premium features you must set the license key in your `.env` file:

```dotenv
FULL_CALENDAR_LICENSE_KEY="your-license-key-here"
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
