<?php

namespace Modules\Core\Traits\Adapters;

use Modules\Core\App\Enums\Guards;

trait PermissionAdapters
{
    /**
     * Generate a badge for the permission readable name.
     */
    public function readableNameBadge(): string
    {
        if (!$this->name) {
            return '';
        }

        return '<div class="badge soft-secondary">' . htmlspecialchars($this->readableName()) . '</div>';
    }

    /**
     * Generate a badge for the guard name.
     */
    public function guardBadge(): string
    {
        if (!$this->guard_name) {
            return '';
        }

        return '<div class="badge soft-info">' . htmlspecialchars(Guards::tryFrom($this->guard_name)->capitalized()) . '</div>';
    }

    /**
     * Return a formatted version of the permission name.
     * e.g., "read_dashboard" → "Read Dashboard"
     */
    public function readableName(): string
    {
        $explode = explode('.', $this->name);
        $action = $explode[0]; // Create, Read, Update, Delete, Extra, Etc.
        $feature = $explode[1] ?? '';

        return ucfirst($action) . ': ' . ucfirst(str_replace(['-', '_'], ' ', $feature));
    }

    /**
     * Show the created date in a badge.
     */
    public function createdAtBadge(): string
    {
        return '<div class="badge soft-dark">' . $this->created_at->format('M d, Y') . '</div>';
    }

    /**
     * Show a status label based on prefix like 'read', 'write', etc.
     */
    public function permissionTypeBadge(): string
    {
        $type = explode('_', $this->name)[0] ?? 'other';

        return match ($type) {
            'read' => '<div class="badge soft-primary">Read</div>',
            'write' => '<div class="badge soft-warning">Write</div>',
            'delete' => '<div class="badge soft-danger">Delete</div>',
            'update' => '<div class="badge soft-success">Update</div>',
            default => '<div class="badge soft-secondary">' . ucfirst($type) . '</div>',
        };
    }

    /**
     * Combine name and type badges.
     */
    public function summaryBadge(): string
    {
        return implode(' ', [
            $this->permissionTypeBadge(),
            $this->guardBadge(),
            $this->createdAtBadge(),
        ]);
    }
}
