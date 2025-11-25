<?php

namespace Modules\Core\Traits\Adapters;

trait VendorAdapters
{
    /**
     * Generate a badge indicating the vendor's email verification status.
     *
     * @return string The HTML for the verification badge.
     */
    public function verifiedBadge()
    {
        if ($this->email_verified_at) {
            return '<div class="badge badge-primary" title="' . dateTimeTranslated($this->email_verified_at) . '" data-toggle="tooltip">Sudah</div>';
        }

        return '<div class="badge badge-secondary">Belum</div>';
    }

    /**
     * Retrieve the vendor's avatar URL.
     *
     * @return string The URL of the vendor's avatar or a default avatar if none is set.
     */
    public function getAvatar()
    {
        return $this->avatar ? url($this->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }

    /**
     * Generate a badge indicating the vendor's account status.
     *
     * @return string The HTML for the account status badge.
     */
    public function activeBadge()
    {
        switch ($this->status) {
            case 'active':
                return '<div class="badge soft-success">Aktif</div>';
            case 'inactive':
                return '<div class="badge soft-dark">Tidak Aktif</div>';
            case 'disable':
                return '<div class="badge soft-danger">Ditangguhkan</div>';
            default:
                return '<div class="badge soft-dark">-</div>';
        }
    }

    /**
     * Generate badges for the vendor's roles.
     *
     * @return string The HTML for the role badges.
     */
    public function roleBadges()
    {
        $roles = collect($this->roles)->map(function ($role) {
            return '<div class="badge soft-dark">' . htmlspecialchars($role->name) . '</div>';
        })->implode('');

        return '<div class="flex flex-wrap gap-2">' . $roles . '</div>';
    }
}
