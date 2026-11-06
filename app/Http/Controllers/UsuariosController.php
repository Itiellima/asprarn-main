<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuariosController extends Controller
{
    // Ordem de exibição (a mesma prioridade do dashboard) e o que cada perfil acessa
    public const PERFIS = [
        'admin' => ['cor' => 'danger', 'descricao' => 'Acesso total, inclusive usuários e diretoria'],
        'moderador' => ['cor' => 'warning', 'descricao' => 'Administrativo: associados, documentos, configurações'],
        'financeiro' => ['cor' => 'info', 'descricao' => 'Pagamentos, planos e gestão financeira'],
        'associado' => ['cor' => 'success', 'descricao' => 'Carteirinha e os próprios dados'],
        'user' => ['cor' => 'secondary', 'descricao' => 'Sem acesso ao painel'],
    ];

    public function index()
    {
        $ordem = array_keys(self::PERFIS);
        $roles = Role::withCount('users')->get()
            ->sortBy(fn ($role) => in_array($role->name, $ordem) ? array_search($role->name, $ordem) : PHP_INT_MAX)
            ->values();

        $search = request('search');

        // Perfil inexistente na URL é ignorado (o scope role() lançaria erro)
        $perfil = request('perfil');
        if ($perfil !== 'sem-perfil' && !$roles->contains('name', $perfil)) {
            $perfil = null;
        }

        $users = User::query()
            ->with(['roles', 'associado'])
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($perfil === 'sem-perfil', fn ($query) => $query->doesntHave('roles'))
            ->when($perfil && $perfil !== 'sem-perfil', fn ($query) => $query->role($perfil))
            ->orderBy('name')
            ->paginate(10);

        $perfis = self::PERFIS;
        $totalUsuarios = User::count();
        $semPerfil = User::doesntHave('roles')->count();

        return view('usuarios.index', compact('users', 'roles', 'search', 'perfil', 'perfis', 'totalUsuarios', 'semPerfil'));
    }

    public function updateRole(Request $request, $id)
    {
        $dados = $request->validate([
            'roles' => 'array',
            'roles.*' => ['string', Rule::exists('roles', 'name')],
        ]);

        $user = User::findOrFail($id);
        $roles = $dados['roles'] ?? [];

        if ($user->hasRole('admin') && !in_array('admin', $roles)) {
            if ($user->is(Auth::user())) {
                return redirect()->back()->with('error', 'Você não pode remover o seu próprio perfil de administrador.');
            }

            if ($this->ehUltimoAdmin($user)) {
                return redirect()->back()->with('error', 'Este é o único administrador do sistema e não pode perder o perfil.');
            }
        }

        $user->syncRoles($roles);

        return redirect()->back()->with('success', "Perfis de {$user->name} atualizados!");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->is(Auth::user())) {
            return redirect()->back()->with('error', 'Você não pode apagar a sua própria conta por aqui.');
        }

        if ($this->ehUltimoAdmin($user)) {
            return redirect()->back()->with('error', 'Este é o único administrador do sistema e não pode ser apagado.');
        }

        $user->delete();

        return redirect()->back()->with('success', "Usuário {$user->name} apagado.");
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

        // Mesma senha padrão do cadastro: o CPF só com números, com troca exigida no próximo login
        $usuario->forceFill([
            'password' => Hash::make(preg_replace('/\D/', '', $usuario->associado->cpf)),
            'trocar_senha' => true,
        ])->save();

        return redirect()->back()->with('success', "Senha de {$usuario->name} resetada para o CPF do associado!");
    }

    private function ehUltimoAdmin(User $user): bool
    {
        return $user->hasRole('admin') && User::role('admin')->count() === 1;
    }
}
