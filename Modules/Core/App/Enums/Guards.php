<?php

namespace Modules\Core\App\Enums;

enum Guards: string
{
    case WEB = 'web';
    case CUSTOMER = 'customer';
    case VENDOR = 'vendor';

    /**
     * Get the lowercase string representation of the enum value.
     *
     * @return string
     */
    public function lower(): string
    {
        return match ($this) {
            self::WEB => 'web',
            self::CUSTOMER => 'customer',
            self::VENDOR => 'vendor',
        };
    }

    /**
     * Get the capitalized string representation of the enum value.
     *
     * @return string
     */
    public function capitalized(): string
    {
        return match ($this) {
            self::WEB => 'Web',
            self::CUSTOMER => 'Customer',
            self::VENDOR => 'Vendor',
        };
    }

    /**
     * Get the description of the enum value.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::WEB => 'Web guard for user authentication.',
            self::CUSTOMER => 'Customer guard for customer access.',
            self::VENDOR => 'Vendor guard for vendor access.',
        };
    }

    /**
     * Get the index route name for the guard.
     *
     * @return string
     */
    public function indexRoute(): string
    {
        return match ($this) {
            self::WEB => 'panel.index',
            self::CUSTOMER => 'customer.index',
            self::VENDOR => 'vendor.index',
        };
    }

    /**
     * Get the prefix route for the guard.
     *
     * @return string
     */
    public function prefixRoute(): string
    {
        return match ($this) {
            self::WEB => 'panel',
            self::CUSTOMER => 'customer',
            self::VENDOR => 'vendor',
        };
    }

    /**
     * Get the email verification notice route name.
     *
     * @return string
     */
    public function verificationNoticeRoute(): string
    {
        return match ($this) {
            self::WEB => 'auth.verification.notice',
            self::CUSTOMER => 'customer.verification.notice',
            self::VENDOR => 'vendor.verification.notice',
        };
    }

    /**
     * Get the forgot password route name.
     *
     * @return string
     */
    public function forgotPasswordRoute(): string
    {
        return match ($this) {
            self::WEB => 'web.password.request',
            self::CUSTOMER => 'auth.customer.password.request',
            self::VENDOR => 'auth.vendor.password.request',
        };
    }

    /**
     * Get the login route name.
     *
     * @return string
     */
    public function loginRoute(): string
    {
        return match ($this) {
            self::WEB => 'auth.login',
            self::CUSTOMER => 'auth.customer.login',
            self::VENDOR => 'auth.vendor.login',
        };
    }

    /**
     * Check if the current guard is WEB.
     *
     * @return bool
     */
    public function isWeb(): bool
    {
        return $this === self::WEB;
    }

    /**
     * Check if the current guard is CUSTOMER.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this === self::CUSTOMER;
    }

    /**
     * Check if the current guard is VENDOR.
     *
     * @return bool
     */
    public function isVendor(): bool
    {
        return $this === self::VENDOR;
    }

    /**
     * Get the next guard in a predefined order.
     *
     * @return self
     */
    public function nextGuard(): self
    {
        return match ($this) {
            self::WEB => self::CUSTOMER,
            self::CUSTOMER => self::VENDOR,
            self::VENDOR => self::WEB,
        };
    }

    /**
     * Check if the current guard is equal to the given guard.
     *
     * @param string $guard
     * @return bool
     */
    public function isGuard(string $guard): bool
    {
        return $this->value === $guard;
    }
}
