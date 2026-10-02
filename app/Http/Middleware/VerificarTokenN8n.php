<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarTokenN8n
{
    /**
     * Libera a requisição apenas se o header x-api-key
     * for igual ao N8N_API_KEY configurado no .env.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenEsperado = config('services.n8n.token');
        $tokenRecebido = $request->header('x-api-key');

        // Sem token configurado, o endpoint fica fechado
        if (empty($tokenEsperado) || !is_string($tokenRecebido) || !hash_equals($tokenEsperado, $tokenRecebido)) {
            abort(401, 'Token inválido');
        }

        return $next($request);
    }
}
