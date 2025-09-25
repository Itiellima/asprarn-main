<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Associado;

class DashboardController extends Controller
{

    public function index()
    {
        // Usuario conectado
        $user = Auth::user();

        // Roles do usuário
        $userRoles = $user->roles->pluck('name')->toArray();

        // Prioridade de roles
        $priority = ['admin', 'moderador', 'associado'];

        // Pega a role com maior prioridade
        $role = collect($priority)->first(fn($r) => in_array($r, $userRoles));

        if (!$role) {
            abort(403, 'Acesso negado.');
        }

        // Admin ou moderador → pega todos os associados
        if (in_array($role, ['admin', 'moderador'])) {
            $associados = Associado::all();
            
            return view("dashboard.admin", compact('user', 'associados'));
        }

        // Associado → pega apenas o associado vinculado ao usuário logado
        if ($role === 'associado') {
            $associado = $user->associado;
            if (!$associado) {
                abort(403, 'Acesso negado.');
            }
            return view("dashboard.associado", compact('user', 'associado'));
        }
    }

}
