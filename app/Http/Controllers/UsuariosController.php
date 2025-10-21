<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $roles = Role::all();


        $search = request('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10);


        return view('usuarios.index', compact('users', 'roles', 'search'));
    }

    public function updateRole(Request $request, $id)
    {
        // Verifica se o usuário autenticado é admin
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Valida a entrada
        $user = User::findOrFail($id);
        $roles = $request->input('roles', []);

        // Atualiza as roles do usuário
        $user->syncRoles($roles);

        return redirect()->route('usuarios.index')->with('success', 'Roles atualizadas com sucesso!');
    }

    public function destroy($id)
    {
        // Verifica se o usuário autenticado é admin
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário deletado com sucesso!');
    }
}
