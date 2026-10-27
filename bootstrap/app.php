<?php

use App\Http\Controllers\MidiaController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Fora do grupo "web": servir uma imagem não abre sessão nem passa pelo login
            Route::get('/midia/{path}', [MidiaController::class, 'show'])
                ->where('path', '(img|picture_profiles)/[A-Za-z0-9._-]+')
                ->name('midia');
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middlewares: a classe fica em app/Http/Middleware (php artisan make:middleware Nome)
        // e só roda depois de registrada. Os do próprio Laravel (sessão, CSRF, cookies)
        // já vêm registrados; aqui fica só o que o projeto acrescenta ou muda.
        //
        //   Rodar em toda requisição         -> $middleware->append(Classe::class)
        //   Rodar em toda rota web           -> $middleware->web(append: [Classe::class])
        //   Rodar em algumas rotas (apelido) -> $middleware->alias([...]) aqui
        //                                       + ->middleware('apelido') na rota
        //   Rodar em algumas rotas (classe)  -> ->middleware(Classe::class) direto na rota,
        //                                       sem registrar aqui (ex.: VerificarTokenN8n)
        //
        // O alias só dá um nome: o middleware roda apenas nas rotas que usam o apelido.
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);

        // O container só recebe tráfego pelo proxy do Easypanel: confia nele para
        // obter o IP real do usuário (limite de tentativas de login) e o https
        $middleware->trustProxies(at: '*');

        // Obriga a trocar a senha padrão (CPF) antes de usar o sistema
        $middleware->web(append: [
            \App\Http\Middleware\ExigirTrocaDeSenha::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
