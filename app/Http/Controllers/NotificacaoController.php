<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacao;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $notificacoes = Notificacao::with('associado')
            ->orderByDesc('created_at')
            ->get();
        

        return view('notificacoes.index', compact('notificacoes'));
    }

    public function marcarComoLida($id)
    {

        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado. Você não tem permissão mudar o estado da notificacão.');
        }

        $notificacao = Notificacao::findOrFail($id);

        $notificacao->update([
            'lida' => ! $notificacao->lida
        ]);

        return redirect()->back();
    }
}
