<?php

namespace Modules\Core\Traits\Adapters;

use Modules\Core\App\Enums\UserStatus;
use Illuminate\Support\Facades\Storage;

trait UserAdapters
{
    /**
     * Show a short date badge for creation date.
     */
    public function createdAtBadge(): string
    {
        return '<div class="badge soft-dark">' . $this->created_at->format('M d, Y') . '</div>';
    }

    /**
     * Get the user's avatar URL.
     *
     * @return string The URL of the user's avatar or a generated default avatar
     */
    public function getAvatar(): string
    {
        return $this->avatar
            ? Storage::url($this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }

    /**
     * Get a badge showing the email verification status.
     *
     * @return string HTML badge showing verification status
     */
    public function verifiedBadge(): string
    {
        return $this->email_verified_at
            ? '<span class="grid place-items-center text-lg text-blue-700 size-6 dark:text-blue-700" title="' . e(dateTimeTranslated($this->email_verified_at)) . '"><i class="bx bxs-badge-check"></i></span>'
            : '<span class="grid place-items-center text-lg text-yellow-500 size-6 dark:text-yellow-300" title="Email not verified"><i class="bx bxs-badge-exclamation"></i></span>';
    }

    /**
     * Get a badge showing the current user status using the UserStatus enum.
     *
     * @return string HTML badge showing user status
     */
    public function getStatusBadge(): string
    {
        try {
            $status = $this->getStatus();

            return sprintf(
                '<div class="badge %s" title="%s">%s</div>',
                e($status->color()),
                e($status->description()),
                e($status->label())
            );
        } catch (\Throwable $e) {
            return '<div class="badge soft-dark">Unknown</div>';
        }
    }

    /**
     * Get the user's status as a UserStatus enum instance.
     *
     * @return UserStatus
     */
    public function getStatus(): UserStatus
    {
        return UserStatus::from($this->status);
    }

    /**
     * Get rendered badges for all user roles.
     *
     * @return string HTML badges for user roles
     */
    public function roleBadges(): string
    {
        $badges = collect($this->roles)->map(function ($role) {
            return '<div class="badge soft-dark">' . e($role->name) . '</div>';
        })->implode('');

        return '<div class="flex flex-wrap gap-2">' . $badges . '</div>';
    }

    /**
     * Get the user's full name or fallback to email.
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->name ?: $this->email;
    }

    /**
     * Check if the user is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getStatus() === UserStatus::ACTIVE;
    }

    /**
     * Get the total number of roles assigned to the user.
     *
     * @return int
     */
    public function getRolesCount(): int
    {
        return $this->roles()->count();
    }

    /**
     * Get a badge showing the total number of roles.
     *
     * @return string HTML badge showing roles count
     */
    public function rolesCountBadge(): string
    {
        $count = $this->getRolesCount();
        return '<div class="badge soft-info">' . $count . ' ' . ($count === 1 ? 'Role' : 'Roles') . '</div>';
    }
    /**
     * Get badges showing all user roles.
     *
     * @return string HTML badges showing all roles
     */
    public function rolesBadge(): string
    {
        $roles = $this->roles->map(function ($role) {
            return '<div class="badge soft-info">' . e($role->name) . '</div>';
        })->implode('');

        return '<div class="flex flex-wrap gap-2">' . $roles . '</div>';
    }

    /**
     * Get the user's last login date in a formatted string.
     *
     * @return string|null
     */
    public function getLastLoginDate(): ?string
    {
        return $this->last_login_at?->format('M d, Y H:i:s');
    }

    /**
     * Get a badge showing the last login date.
     *
     * @return string HTML badge showing last login
     */
    public function lastLoginBadge(): string
    {
        if (!$this->last_login_at) {
            return '<div class="badge soft-dark">Never</div>';
        }

        return '<div class="badge soft-info" title="' . e($this->getLastLoginDate()) . '">Last Login</div>';
    }

    /**
     * Get a badge indicating if the user has roles.
     *
     * @return string HTML badge showing roles status
     */
    public function rolesStatusBadge(): string
    {
        return $this->hasAnyRoles()
            ? '<div class="badge soft-success">Has Roles</div>'
            : '<div class="badge soft-danger">No Roles</div>';
    }
}
