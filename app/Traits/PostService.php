<?php

namespace App\Traits;

class PostService
{
    /**
     * Generate reading time by post content length
     * Normal reading time 130 word/min.
     *
     * @param  string $content
     * @return string reading time
     */
    public static function generateReadingTime(string $content): string
    {
        return round(str_word_count(strip_tags($content)) / 130, 1) . ' Menit';
    }
}