<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManageUsers extends Component
{
    public $users;

    public function mount()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Acesso negado.');
        }
        // Carrega todos os usuários ao montar o componente
        $this->users = User::all();
        
    }

    public function toggleRole($userId)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Acesso negado.');
        }
        // Verifica se o usuário existe
        $user = User::findOrFail($userId);
        // Alterna o papel do usuário entre 'admin' e 'user'
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        // Salva as alterações no usuário
        $user->save();

        // Atualiza a lista sem precisar recarregar a página
        $this->users = User::all();
    }

    public function render()
    {
        // Retorna a view do componente
        return view('livewire.manage-users');
    }
}
