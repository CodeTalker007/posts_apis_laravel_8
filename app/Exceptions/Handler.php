<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (ValidationException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => trans('exception.validation'),
                'errors' => $exception->errors()
            ], 422);
        });

        $this->renderable(function (AuthenticationException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => trans('exception.unauthorized'),
                'errors' => []
            ], 401);
        });
        $this->renderable(function (NotFoundHttpException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => trans('exception.entity_not_found'),
                'errors' => []
            ], 404);
        });
        $this->renderable(function (AccessDeniedHttpException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => trans($exception->getMessage()),
                'errors' => []
            ], $exception->getStatusCode());
        });

        $this->renderable(function (ErrorException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => trans($exception->getName(), $exception->getParams()),
                'errors' => $exception->getParams()
            ], $exception->getStatusCode());
        });
    }
}
