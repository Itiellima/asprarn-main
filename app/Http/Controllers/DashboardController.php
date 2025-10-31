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

        if (!$user) {
            abort(403, 'Usuario não autenticado.');
        }

        // Roles do usuário
        $userRoles = $user->roles->pluck('name')->toArray();

        // Prioridade de roles
        $priority = ['admin', 'moderador', 'associado'];

        // Pega a role com maior prioridade
        $role = collect($priority)->first(fn($r) => in_array($r, $userRoles));

        if (!$role) {
            abort(403, 'Acesso negado.');
        }

        return match ($role) {
            'admin', 'moderador' => $this->adminDashboard($user),
            'associado' => $this->associadoDashboard($user),
            default => abort(403, 'Acesso negado.'),
        };
    }


    private function adminDashboard($user)
    {
        $associados = Associado::all();
        return view("dashboard.admin", compact('user', 'associados'));
    }

    private function associadoDashboard($user)
    {
        $associado = $user->associado;
        if (!$associado) {
            abort(403, 'Acesso negado.');
        }
        return view('dashboard.associado', compact('user', 'associado'));
    }


}
