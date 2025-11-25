<?php

namespace Modules\Core\Traits\Adapters;

use Modules\Core\App\Enums\Guards;

trait RoleAdapters
{
    /**
     * Generate a badge indicating the role's guard.
     */
    public function guardBadge(): string
    {
        if (!$this->guard_name) {
            return '';
        }
        return '<div class="badge soft-info">' . htmlspecialchars(Guards::tryFrom($this->guard_name)->capitalized()) . '</div>';
    }

    /**
     * Generate a badge indicating the count of permissions for the role.
     */
    public function permissionCountBadge(): string
    {
        $count = $this->permissions_count;
        return '<div class="badge soft-primary">' . $count . ' ' . ($count === 1 ? 'Permission' : 'Permissions') . '</div>';
    }

    /**
     * Show a short date badge for creation date.
     */
    public function createdAtBadge(): string
    {
        return '<div class="badge soft-dark">' . $this->created_at->format('M d, Y') . '</div>';
    }

    /**
     * Display if role has any permissions at all.
     */
    public function permissionsCount(): bool
    {
        return $this->permissions_count > 0;
    }

    /**
     * Display a status badge if the role has no permissions.
     */
    public function permissionStatusBadge(): string
    {
        return $this->permissionsCount()
            ? '<div class="badge soft-success">Active</div>'
            : '<div class="badge soft-danger">No Permissions</div>';
    }

    /**
     * Return a human-readable version of the role name.
     */
    public function readableName(): string
    {
        return ucfirst(str_replace(['_', '-'], ' ', $this->name));
    }

    /**
     * Generate HTML for full role summary.
     */
    public function roleSummaryBadge(): string
    {
        return implode(' ', [
            $this->permissionCountBadge(),
            $this->guardBadge(),
            $this->createdAtBadge(),
        ]);
    }
}
