<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExigirTrocaDeSenha
{
    /**
     * Enquanto o usuário estiver marcado com trocar_senha,
     * só deixa acessar a tela de troca de senha e o logout.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->trocar_senha) {
            return $next($request);
        }

        if ($request->routeIs('senha.trocar', 'senha.trocar.salvar', 'logout')) {
            return $next($request);
        }

        if ($request->expectsJson() || $request->hasHeader('X-Livewire')) {
            abort(403, 'Troque sua senha para continuar.');
        }

        return redirect()->route('senha.trocar');
    }
}
