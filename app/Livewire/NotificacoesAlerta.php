<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notificacao;

class NotificacoesAlerta extends Component
{

    public function render()
    {

        $notificacoes = Notificacao::where('lida', false)->get();

        return view('livewire.notificacoes-alerta', [
            'notificacoes' => $notificacoes
        ]);
    }
}
