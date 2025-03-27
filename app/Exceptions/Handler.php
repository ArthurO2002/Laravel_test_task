<?php

namespace App\Exceptions;

use App\Enums\ErrorMessagesEnum;
use App\Enums\ErrorTitlesEnum;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    public function register(Exceptions $exceptions): void
    {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'error' => ErrorTitlesEnum::ValidationErrorTitle->value,
                        'errors' => $e->errors(),
                    ], 422);
                } elseif ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'error' => ErrorTitlesEnum::NotFoundErrorTitle->value,
                    ], 404);
                } elseif ($e instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        'error' => ErrorTitlesEnum::NotAllowedMethodErrorTitle->value,
                        'message' => ErrorMessagesEnum::MethodNotAllowed->value,
                    ], 405);
                } else {
                    return response()->json([
                        'error' => ErrorTitlesEnum::UnexpectedErrorTitle->value,
                        'message' => ErrorMessagesEnum::UnexpectedError->value,
                    ], 500);
                }
            }
        });
    }
}
