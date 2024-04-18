<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
//importing the middleware of roles auth
use App\Http\Middleware\Admin;
use App\Http\Middleware\EventAdmin;
use App\Http\Middleware\User;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    ) 
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ])
        //adding multi roles authentication (below are middleware class not model)
        //these key('admin', etc) are passed into web.php or routes
        ->alias([
            'admin' => Admin::class,
            'eventadmin' => EventAdmin::class,
            'user' => User::class,
        ]);
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
