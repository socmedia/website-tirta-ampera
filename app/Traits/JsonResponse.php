<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Response;

trait JsonResponse
{
    /**
     * JSON formatter for a successful response.
     *
     * @param  string|null $message The success message.
     * @param  mixed $data The data to return.
     * @param  bool $pagination Indicates if pagination is applied.
     * @return Response
     */
    public function success(
        string $message = null,
        mixed $data,
        bool $pagination = false
    ) {
        $response = [
            'message' => $message ?? 'Success getting data.',
        ];

        if (!$pagination) {
            $response['data'] = $data;
        } else {
            $response = array_merge($response, $data);
        }

        return response()->json($response, 200)->setStatusCode(200);
    }

    /**
     * JSON formatter for an error response.
     *
     * @param  string|null $message The error message.
     * @param  Exception $exception The exception that occurred.
     * @param  int $status_code The HTTP status code.
     * @return Response
     */
    public function error(
        string $message = null,
        $exception,
        int $status_code = 500
    ) {
        // Determine the status code from the exception if applicable
        if ($exception instanceof Exception) {
            if (method_exists($exception, 'getStatusCode')) {
                $status_code = $exception->getStatusCode();
            } elseif (method_exists($exception, 'getCode')) {
                $status_code = ($exception->getCode() >= 400 && $exception->getCode() <= 600) ? $exception->getCode() : 500;
            }
        }

        // Handle JSON response for the error message
        $error = json_decode($exception->getMessage()) ?: $exception->getMessage();

        return response()->json([
            'message' => $message ?? 'There is something wrong.',
            'error' => $error,
        ], $status_code);
    }
}
