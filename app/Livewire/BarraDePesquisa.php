<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class BarraDePesquisa extends Component
{

    public string $search = '';

    public function pesquisar()
    {
        return redirect()->route('search', ['search' => $this->search]);
    }

    public function render()
    {
        return view('livewire.barra-de-pesquisa');
    }
}
