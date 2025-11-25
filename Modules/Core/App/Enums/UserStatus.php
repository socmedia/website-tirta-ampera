<?php

namespace Modules\Core\App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DISABLE = 'disable';

    /**
     * Get a human-readable label for the current user status.
     */
    public function label(): string
    {
        return ucwords(str_replace('_', ' ', $this->value));
    }

    /**
     * Get the background badge color class for the user status.
     */
    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'badge soft-success',    // Green
            self::INACTIVE => 'badge soft-secondary', // Gray
            self::DISABLE => 'badge soft-danger',    // Red
        };
    }

    /**
     * Get the text color class for the user status.
     */
    public function textColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'text-success',
            self::INACTIVE => 'text-muted',
            self::DISABLE => 'text-danger',
        };
    }

    /**
     * Get a full description for the status.
     */
    public function description(): string
    {
        return match ($this) {
            self::ACTIVE   => 'Active – This user account is active and fully functional.',
            self::INACTIVE => 'Inactive – This user is not currently active but may be reactivated.',
            self::DISABLE  => 'Disabled – This account has been disabled and cannot be used.',
        };
    }

    /**
     * Optional: Return an icon class or name (e.g., for a UI).
     */
    public function icon(): string
    {
        return match ($this) {
            self::ACTIVE   => 'heroicon-check-circle',
            self::INACTIVE => 'heroicon-pause-circle',
            self::DISABLE  => 'heroicon-x-circle',
        };
    }

    /**
     * Optional: Return a short tooltip-style explanation.
     */
    public function tooltip(): string
    {
        return match ($this) {
            self::ACTIVE   => 'User is currently active.',
            self::INACTIVE => 'User is inactive and cannot login.',
            self::DISABLE  => 'User account is disabled permanently.',
        };
    }
}
