<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// On Vercel (read-only filesystem), redirect storage to /tmp
$defaultStorage = dirname(__DIR__) . '/storage';
if (!is_writable($defaultStorage) && is_writable('/tmp')) {
    $storagePath = '/tmp/storage';
    foreach ([
        'app/public',
        'framework/cache/data',
        'framework/sessions',
        'framework/testing',
        'framework/views',
        'logs',
    ] as $dir) {
        @mkdir("$storagePath/$dir", 0755, true);
    }
    $app->useStoragePath($storagePath);
}

return $app;
