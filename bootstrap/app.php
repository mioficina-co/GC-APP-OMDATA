<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Livewire\Exceptions\MethodNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (MethodNotFoundException $e, Request $request) {
            if ($request->is('livewire/update')) {
                return response()->json(['message' => 'Not Found'], 404);
            }
        });

        $exceptions->renderable(function (BadMethodCallException $e, Request $request) {
            if ($request->is('livewire/update')) {
                return response()->json(['message' => 'Not Found'], 404);
            }
        });
    })
    ->create();
