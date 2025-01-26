<?php

use App\Helpers\ResponseJSON;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'api-key-data-peserta' => \App\Http\Middleware\DataPesertaApisMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e, $request) use ($exceptions) {
            if ($request->is('api/v0/*')) {
                $status = $e->getCode() ?: 500;
                Log::error($e);

                if ($e instanceof ValidationException) {
                    return ResponseJSON::error($e->validator->errors(), $status);
                }

                return ResponseJSON::error($e->getMessage(), $status);
            }
        });
    })->create();
