<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'billing/ipn',
        ]);
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'patient' => \App\Http\Middleware\PatientAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->isMethod('GET')) {
                return response()->view('errors.403', [], 403);
            }

            return back()->with('error', 'Unauthorized: You do not have permission to perform this action.');
        });
    })->create();
