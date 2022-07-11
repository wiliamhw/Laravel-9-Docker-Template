<?php

namespace App\Exceptions;

use App\Exceptions\Traits\HandleApiExceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use HandleApiExceptions;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = ["current_password", "password", "password_confirmation"];

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     *
     * @throws Throwable
     *
     * @return Response
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function render($request, Throwable $e): Response
    {
        if ($request->expectsJson() || Str::startsWith($request->getRequestUri(), ["/api/"])) {
            return $this->renderApiException($e);
        }

        return parent::render($request, $e);
    }
}
