<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use App\Http\Handler\NoPermissionHandler;
use App\Http\Handler\NotFoundHandler;
use App\Http\Handler\UnauthenticatedHandler;
use App\Http\Handler\ValidationErrorHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
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
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e) {
        if ($e instanceof UnauthorizedException) return NoPermissionHandler::handle($request, $e);
        else if ($e instanceof ModelNotFoundException) return NotFoundHandler::handle($request, $e);
        else if ($e instanceof ValidationException) return ValidationErrorHandler::handle($request, $e);
        else if ($e instanceof AuthenticationException) return UnauthenticatedHandler::handle($request, $e);

        return (new Controller())->sendError('Something went wrong', [
            'error' => $e->getMessage(),
            'path' => $e->getFile() . ' @ ' . $e->getLine(),
            'stack' => $e->getTrace()
        ], 500);
    }
}
