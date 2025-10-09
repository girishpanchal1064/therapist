<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Facade;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
    then: function () {
      Route::middleware('web')
        ->group(base_path('routes/admin.php'));
    },
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
      'role' => \App\Http\Middleware\CheckRole::class,
      'backend.access' => \App\Http\Middleware\BackendAccess::class,
    ]);
  })
  ->withProviders([
    \App\Providers\MenuServiceProvider::class,
    \App\Providers\DataTablesServiceProvider::class,
  ])
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
