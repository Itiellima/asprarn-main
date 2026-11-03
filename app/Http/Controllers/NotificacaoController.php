<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacao;

class NotificacaoController extends Controller
{
    public function index()
    {
        $notificacoes = Notificacao::with('associado')

            ->when(request()->has('nao_lida'), function($query){
                $query->where('lida', 0);
            })

            ->orderByDesc('created_at')
            ->paginate(10);


        return view('notificacoes.index', compact('notificacoes'));
    }

    public function marcarComoLida($id)
    {
        $notificacao = Notificacao::findOrFail($id);

        $notificacao->update([
            'lida' => ! $notificacao->lida
        ]);

        return redirect()->back();
    }
}
