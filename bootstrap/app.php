<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    });

// Charger le fournisseur de services de test si nous sommes en environnement de test
if (($_ENV['APP_ENV'] ?? '') === 'testing' && isset($_SERVER['APP_SERVICE_PROVIDER'])) {
    $provider = $_SERVER['APP_SERVICE_PROVIDER'];
    if (class_exists($provider)) {
        $app->withProviders([$provider]);
    }
}

return $app->create();
