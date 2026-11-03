<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Associado;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index()
    {
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
        // Valida a entrada
        $user = User::findOrFail($id);
        $roles = $request->input('roles', []);

        // Atualiza as roles do usuário
        $user->syncRoles($roles);

        return redirect()->route('usuarios.index')->with('success', 'Roles atualizadas com sucesso!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário deletado com sucesso!');
    }

    public function resetPassword($id)
    {
        $user = Auth::user();
        $usuario = User::with('associado')->findOrFail($id);

        // Só admin pode resetar a senha de outro admin
        if ($usuario->hasRole('admin') && !$user->hasRole('admin')) {
            return redirect()->back()->with('error', 'Apenas administradores podem resetar a senha de um administrador.');
        }

        if (!$usuario->associado) {
            return redirect()->back()->with('error', 'Este usuário não está vinculado a um associado.');
        }

        $usuario->update([
            'password' => Hash::make($usuario->associado->cpf)
        ]);

        return redirect()->back()->with('success', 'Senha resetada para o CPF do associado!');

    }
}
