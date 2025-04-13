<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Requests\ContaRequest;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'conta',
            'transacao',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*') || $request->wantsJson();
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ContaRequest $e, Request $request) {
            return $request->expectsJson();
        });

        $exceptions->renderable(function (NotFoundHttpException $e) {
            return response()->json([
                'message' => 'Record not found.'
            ], StatusCodeInterface::STATUS_NOT_FOUND);
        });
    })->create();
