<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddBookingCalendarPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view booking calendar' => ['Owner', 'Executive', 'Staff'],
        ];

        $this->createPermissions($permissions);
    }
}
