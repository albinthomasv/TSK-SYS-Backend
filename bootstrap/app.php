<?php


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use app\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\View\ViewException;
use App\Helpers\HttpResponseHelper;
use App\Http\Middleware\HandleCors;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return HttpResponseHelper::error($e->getMessage(), 401);
        });
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            return HttpResponseHelper::error($e->getMessage(), 405);
        });
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return HttpResponseHelper::error($e->getMessage(), 404);
        });
        $exceptions->render(function (QueryException $e, Request $request) {
            return HttpResponseHelper::error($e->getMessage(), 500);
        });
        $exceptions->render(function (ViewException $e, Request $request) {
            return HttpResponseHelper::error('An error occurred', 500);
        });
    })->create();
