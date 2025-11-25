<?php

namespace Modules\Common\Enums;

enum ContactMessage
{
    case HELPDESK;
    case TECHNICAL;
    case BILLING;
    case FEEDBACK;
    case GENERAL;

    /**
     * Get the lowercase string representation of the enum value.
     *
     * @return string
     */
    public function lower(): string
    {
        return match ($this) {
            self::HELPDESK => 'helpdesk',
            self::TECHNICAL => 'technical',
            self::BILLING => 'billing',
            self::FEEDBACK => 'feedback',
            self::GENERAL => 'general',
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
            self::HELPDESK => 'This message is related to helpdesk inquiries.',
            self::TECHNICAL => 'This message pertains to technical support issues.',
            self::BILLING => 'This message concerns billing inquiries and issues.',
            self::FEEDBACK => 'This message is for providing feedback or suggestions.',
            self::GENERAL => 'This message covers general inquiries and information.',
        };
    }

    /**
     * Check if the current state is HELPDESK.
     *
     * @return bool
     */
    public function isHelpdesk(): bool
    {
        return $this === self::HELPDESK;
    }

    /**
     * Get the next state of the enum value.
     *
     * @return self
     */
    public function nextState(): self
    {
        return match ($this) {
            self::HELPDESK => self::TECHNICAL,
            self::TECHNICAL => self::BILLING,
            self::BILLING => self::FEEDBACK,
            self::FEEDBACK => self::GENERAL,
            self::GENERAL => self::HELPDESK,
        };
    }
}
