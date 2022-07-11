<?php

namespace App\Exceptions\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

trait HandleApiExceptions
{
    /**
     * Convert the content of given exception to array.
     *
     * @param \Throwable $exception
     *
     * @return array
     */
    protected function convertApiExceptionToArray(Throwable $exception): array
    {
        $code = $this->getApiErrorCode($exception);
        $errors = $exception instanceof ValidationException ? $exception->errors() : [];
        $debugEnabled = config("app.debug", false);

        return $debugEnabled === true
            ? [
                "code" => $code,
                "message" => $exception->getMessage(),
                "errors" => $errors,
                "exception" => get_class($exception),
                "file" => $exception->getFile(),
                "line" => $exception->getLine(),
                "trace" => collect($exception->getTrace())
                    ->map(static function ($trace): array {
                        return Arr::except($trace, ["args"]);
                    })
                    ->all(),
            ]
            : [
                "code" => $code,
                "message" => $exception->getMessage(),
                "errors" => $errors,
            ];
    }

    /**
     * Get API error code.
     *
     * @param Throwable $exception
     *
     * @return int
     */
    protected function getApiErrorCode(Throwable $exception): int
    {
        if ($exception instanceof ValidationException) {
            return 422;
        }

        if ($exception instanceof ModelNotFoundException) {
            return 404;
        }

        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        if ($exception instanceof AuthenticationException) {
            return 401;
        }

        if ($exception instanceof AuthorizationException) {
            return 403;
        }

        return 500;
    }

    /**
     * Render the API Exception.
     *
     * @param Throwable $exception
     *
     * @return JsonResponse
     */
    protected function renderApiException(Throwable $exception): JsonResponse
    {
        $headers = $exception instanceof HttpExceptionInterface ? $exception->getHeaders() : [];

        return new JsonResponse(
            $this->convertApiExceptionToArray($exception),
            $this->getApiErrorCode($exception),
            $headers,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES,
        );
    }
}
