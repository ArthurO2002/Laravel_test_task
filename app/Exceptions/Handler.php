<?php

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    /**
     * Register the exception handling callbacks.
     */
    public function register(Exceptions $exceptions): void
    {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'error' => 'Validation failed',
                        'errors' => $e->errors(),
                    ], 422);
                } elseif ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'error' => 'Resource not found',
                    ], 404);
                } elseif ($e instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        'error' => 'Method not allowed',
                        'message' => 'The method is not allowed for this resource',
                    ], 405);
                } else {
                    return response()->json([
                        'error' => 'Something went wrong on the server :(',
                        'message' => 'Something went wrong on the server, please try again later',
                    ], 500);
                }
            }
        });
    }
}
