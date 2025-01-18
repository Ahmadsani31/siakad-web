<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'api-midleware' => \App\Http\Middleware\APIMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (AuthenticationException $e, Request $request) {


            if ($request->is('api/*')) {
                return response()->json([
                    'param' => false,
                    'message' => $e->getMessage(),
                ], 401);
            }
        });

        $exceptions->respond(function (Response $response) {

            if ($response->getStatusCode() === 419) {
                return back()->with([
                    'message' => 'The page expired, please try again.',
                ]);
            } elseif ($response->getStatusCode() === 404) {
                return response()->view('errors.404', status: 404);
            }

            return $response;
        });
    })->create();
