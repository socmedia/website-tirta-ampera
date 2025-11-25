<?php

namespace Modules\Common\Traits\Adapters;

trait FaqAdapters
{
    use TimestampAdapters;

    /**
     * --------------------------------------------------------------------------
     * Accessors
     * --------------------------------------------------------------------------
     * These are Eloquent accessor methods for convenient attribute access.
     * They allow you to retrieve formatted or computed values as if they were
     * regular model properties (e.g., $faq->status_badge).
     */

    /**
     * Accessor for the status badge HTML.
     *
     * @return string
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->status
            ? '<div class="badge soft-info">' . __('Active') . '</div>'
            : '<div class="badge soft-dark">' . __('Inactive') . '</div>';
    }

    /**
     * Accessor for the featured badge HTML.
     *
     * @return string
     */
    public function getFeaturedBadgeAttribute(): string
    {
        return $this->featured
            ? '<div class="badge soft-info">' . __('Featured') . '</div>'
            : '<div class="badge soft-dark">' . __('Not Featured') . '</div>';
    }

    /**
     * Accessor for the question (no translation).
     *
     * @return string|null
     */
    public function getQuestionAttribute(): ?string
    {
        return $this->question ?? null;
    }

    /**
     * Accessor for the answer (no translation).
     *
     * @return string|null
     */
    public function getAnswerAttribute(): ?string
    {
        return $this->answer ?? null;
    }

    /**
     * Accessor for a short preview of the answer.
     *
     * @return string
     */
    public function getAnswerPreviewAttribute(): string
    {
        $length = 80;
        $answer = strip_tags($this->answer ?? '');
        return mb_strlen($answer) > $length
            ? mb_substr($answer, 0, $length) . '...'
            : $answer;
    }
}
