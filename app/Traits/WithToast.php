<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

trait WithToast
{
    /**
     * Show a success toast notification.
     *
     * @param string $message
     * @return void
     */
    public function notifySuccess(string $message): void
    {
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    /**
     * Show an error toast notification.
     *
     * @param \Exception $exception
     * @return void
     */
    public function notifyError(Exception $exception): void
    {
        if ($exception instanceof ValidationException) {
            throw $exception;
        }

        if (app()->environment('production')) {
            Log::error($exception->getMessage(), [
                'exception' => $exception,
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            ]);

            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'An error occurred. Please try again later.'
            ]);

            return;
        }

        $this->dispatch('notify', [
            'type' => 'error',
            'message' => $exception->getMessage()
        ]);
    }

    /**
     * Show a warning toast notification.
     *
     * @param \Exception $exception
     * @return void
     */
    public function notifyWarning(\Exception $exception): void
    {
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            throw $exception;
        }

        $this->dispatch('notify', [
            'type' => 'warning',
            'message' => $exception->getMessage()
        ]);
    }

    /**
     * Show a default toast notification.
     *
     * @param string $message
     * @return void
     */
    public function notifyDefault(string $message): void
    {
        $this->dispatch('notify', [
            'type' => 'default',
            'message' => $message
        ]);
    }
}
