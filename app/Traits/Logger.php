<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait Logger
{
    /**
     * The log file name (without extension).
     *
     * @var string
     */
    public string $logger_file = 'laravel';

    /**
     * Create a logger instance writing to a custom log file.
     *
     * Uses Laravel's Log::build() method with the single driver.
     *
     * @return \Psr\Log\LoggerInterface|null Returns the logger instance or null if an error occurs.
     */
    public function log()
    {
        try {
            return Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/' . $this->logger_file . '.log'),
            ]);
        } catch (Exception $exception) {
            // Optionally log the error somewhere else or handle it
            return null;
        }
    }
}
