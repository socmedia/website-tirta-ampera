<?php

namespace Modules\Common\Enums;

enum ApplicantStatus: string
{
    case PENDING = 'pending';
    case REVIEWED = 'reviewed';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    /**
     * Get a human-readable label for the current status with a capital first letter.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => __('Pending'),
            self::REVIEWED => __('Reviewed'),
            self::ACCEPTED => __('Accepted'),
            self::REJECTED => __('Rejected'),
        };
    }

    /**
     * Check if the given status string matches any enum instance.
     *
     * @param string $status
     * @return bool
     */
    public static function match(string $status): bool
    {
        return self::tryFrom($status) !== null;
    }

    /**
     * Check if the current status matches a given status string.
     *
     * @param string $status
     * @return bool
     */
    public function matches(string $status): bool
    {
        return $this->value === $status;
    }

    /**
     * Get all statuses with labels.
     */
    public static function options(): array
    {
        return array_map(
            fn($status) => [
                'value' => $status->value,
                'label' => $status->label(),
                'disabled' => false
            ],
            self::cases()
        );
    }

    /**
     * Accessor for the applicant's status badge HTML.
     *
     * @return string
     */
    public function badge(): string
    {
        return match ($this) {
            self::ACCEPTED =>
            '<div class="badge soft-primary">' . __('Accepted') . '</div>',
            self::REJECTED =>
            '<div class="badge soft-danger">' . __('Rejected') . '</div>',
            self::REVIEWED =>
            '<div class="badge soft-info">' . __('Reviewed') . '</div>',
            self::PENDING =>
            '<div class="badge soft-dark">' . __('Pending') . '</div>',
            default => '<div class="badge soft-dark">' . __('Pending') . '</div>',
        };
    }

    /**
     * Get the associated text color class for each status.
     */
    public function color(): string
    {
        return match ($this) {
            self::ACCEPTED => 'text-green-600',
            self::REJECTED => 'text-red-600',
            self::REVIEWED => 'text-blue-500',
            self::PENDING => 'text-warning-500',
            default => 'text-gray-600',
        };
    }

    /**
     * Get the next action available for the current status.
     *
     * @return array|null
     */
    public function nextAction(): ?array
    {
        return match ($this) {
            self::PENDING => [
                [
                    'label' => __('Mark as Reviewed'),
                    'value' => self::REVIEWED->value,
                ],
                [
                    'label' => __('Accept'),
                    'value' => self::ACCEPTED->value,
                ],
                [
                    'label' => __('Reject'),
                    'value' => self::REJECTED->value,
                ],
            ],
            self::REVIEWED => [
                [
                    'label' => __('Accept'),
                    'value' => self::ACCEPTED->value,
                ],
                [
                    'label' => __('Reject'),
                    'value' => self::REJECTED->value,
                ],
            ],
            self::ACCEPTED => [
                [
                    'label' => __('Mark as Reviewed'),
                    'value' => self::REVIEWED->value,
                ],
            ],
            self::REJECTED => [
                [
                    'label' => __('Mark as Reviewed'),
                    'value' => self::REVIEWED->value,
                ],
            ],
        };
    }
}
