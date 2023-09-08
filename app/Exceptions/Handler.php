<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

        /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code];
            return response()->json($message, $code);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json('internal.error_not_found', 404);
        }

        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->errors()->first();
            return response()->json($errors, 422);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json('internal.error_unauthorized', 403);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json('internal.error_authentication', 401);
        }

        $message = $exception->getMessage();

        if (Str::contains($message, '[login]')) {
            $message = 'internal.error_token';
        }

        return response()->json($message, 500);
    }
}
