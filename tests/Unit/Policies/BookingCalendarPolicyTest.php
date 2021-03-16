<?php

declare(strict_types=1);

namespace Tipoff\BookingCalendar\Tests\Unit\Policies;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Support\Contracts\Models\UserInterface;
use Tipoff\TestSupport\Models\User;
use Tipoff\BookingCalendar\Tests\TestCase;

class BookingCalendarPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view()
    {
        /** @var User $authorizedUser */
        $authorizedUser = self::createPermissionedUser('view booking calendar', true);

        /** @var User $unauthorizedUser */
        $unauthorizedUser = self::createPermissionedUser('view booking calendar', false);

        $this->assertTrue($authorizedUser->can('view booking calendar'));
        $this->assertFalse($unauthorizedUser->can('view booking calendar'));
    }
}
