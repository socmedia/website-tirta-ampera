<?php

namespace Modules\Common\Traits\Adapters;

use Modules\Common\Traits\Adapters\TimestampAdapters;

trait ContactMessageAdapters
{
    use TimestampAdapters;

    /**
     * --------------------------------------------------------------------------
     * Accessors
     * --------------------------------------------------------------------------
     * These are Eloquent accessor methods for convenient attribute access.
     * They allow you to retrieve formatted or computed values as if they were
     * regular model properties (e.g., $contactMessage->name, $contactMessage->email, etc.).
     */

    /**
     * Get the name attribute.
     *
     * @return string|null
     */
    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    /**
     * Get the email attribute.
     *
     * @return string|null
     */
    public function getEmailAttribute(): ?string
    {
        return $this->attributes['email'] ?? null;
    }

    /**
     * Get the whatsapp_code attribute.
     *
     * @return string|null
     */
    public function getWhatsappCodeAttribute(): ?string
    {
        return $this->attributes['whatsapp_code'] ?? null;
    }

    /**
     * Get the whatsapp_number attribute.
     *
     * @return string|null
     */
    public function getWhatsappNumberAttribute(): ?string
    {
        return $this->attributes['whatsapp_number'] ?? null;
    }

    /**
     * Get the topic attribute.
     *
     * @return string|null
     */
    public function getTopicAttribute(): ?string
    {
        return $this->attributes['topic'] ?? null;
    }

    /**
     * Get the subject attribute.
     *
     * @return string|null
     */
    public function getSubjectAttribute(): ?string
    {
        return $this->attributes['subject'] ?? null;
    }

    /**
     * Get the message attribute.
     *
     * @return string|null
     */
    public function getMessageAttribute(): ?string
    {
        return $this->attributes['message'] ?? null;
    }

    /**
     * Get the seen_at attribute.
     *
     * @return string|null
     */
    public function getSeenAtAttribute(): ?string
    {
        return $this->attributes['seen_at'] ?? null;
    }

    /**
     * Get the seen_by attribute.
     *
     * @return string|null
     */
    public function getSeenByAttribute(): ?string
    {
        return $this->attributes['seen_by'] ?? null;
    }

    /**
     * Get the created_at attribute.
     *
     * @return string|null
     */
    public function getCreatedAtAttribute(): ?string
    {
        return $this->attributes['created_at'] ?? null;
    }

    /**
     * Get the updated_at attribute.
     *
     * @return string|null
     */
    public function getUpdatedAtAttribute(): ?string
    {
        return $this->attributes['updated_at'] ?? null;
    }

    /**
     * Get the formatted WhatsApp number (with code).
     *
     * @return string|null
     */
    public function getWhatsappFormattedAttribute(): ?string
    {
        $code = $this->whatsapp_code;
        $number = $this->whatsapp_number;
        try {
            return phone($number, $code);
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * Get a badge for the seen status.
     *
     * @return string
     */
    public function getSeenBadgeAttribute(): string
    {
        if ($this->seen_at) {
            return '<div class="badge badge-success" title="' . e($this->seen_at) . '" data-toggle="tooltip">Seen</div>';
        }
        return '<div class="badge badge-secondary">Unseen</div>';
    }

    /**
     * Get the background class for the message row based on seen status.
     *
     * @return string
     */
    public function getRowBgAttribute(): string
    {
        // If unseen, return blue background; if seen, return default (empty string)
        if (empty($this->seen_at)) {
            return 'bg-neutral-100/70 dark:bg-neutral-900/30';
        }
        return '';
    }

    /**
     * Check if the message has been seen.
     *
     * @return bool
     */
    public function isSeen(): bool
    {
        return $this->seen_at ? true : false;
    }

    /**
     * Check if the message has not been seen.
     *
     * @return bool
     */
    public function isUnseen(): bool
    {
        return !$this->seen_at ? true : false;
    }
}
