<?php

namespace App\Http\Controllers\Associado;

use App\Http\Controllers\Controller;
use App\Models\Associado;
use App\Models\Situacao;
use Illuminate\Support\Facades\Gate;

class CarteirinhaController extends Controller
{
    public function horizontal($id)
    {
        return $this->exibir($id, 'dashboard.associadoComponents.carteirinha-download');
    }

    public function vertical($id)
    {
        return $this->exibir($id, 'dashboard.associadoComponents.carteirinha-vertical');
    }

    /**
     * Página pública aberta pelo QR code impresso na carteirinha.
     * A URL (/carteira-associado-verificacao/{id}) não pode mudar.
     */
    public function validar($id)
    {
        $associado = Associado::findOrFail($id);
        $situacoes = Situacao::all();

        return view('dashboard.associadoComponents.verificar', compact('associado', 'situacoes'));
    }

    private function exibir($id, string $view)
    {
        $associado = Associado::with('membro.diretoria', 'membro.funcao')->findOrFail($id);
        Gate::authorize('view', $associado);

        $membro = $associado->membro;

        return view($view, compact('associado', 'membro'));
    }
}
