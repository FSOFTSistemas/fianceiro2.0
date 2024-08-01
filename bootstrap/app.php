<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Ocorreu um erro inesperado, tente novamente em outro momento! ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Ocorreu um erro inesperado, tente novamente em outro momento! <br>' . $e->getMessage());
        });

    })->create();
