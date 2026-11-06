@extends('layouts.main')

@section('title', 'AspraRN - Usuários')

@section('content')
    @include('dashboard.layouts.nav-dashboard')

    @php
        $totalAdmins = $roles->firstWhere('name', 'admin')?->users_count ?? 0;
        $filtro = fn ($valor) => route('usuarios.index', array_filter(['search' => $search, 'perfil' => $valor]));
    @endphp

    <div class="container mt-4 mb-5">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Controle de Acesso</h5>
                <small>{{ $totalUsuarios }} usuário(s)</small>
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Totais por perfil: clicar filtra a lista --}}
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ $filtro(null) }}"
                        class="btn btn-sm {{ $perfil ? 'btn-outline-dark' : 'btn-dark' }}">
                        Todos <span class="badge bg-light text-dark ms-1">{{ $totalUsuarios }}</span>
                    </a>

                    @foreach ($roles as $role)
                        @php $cor = $perfis[$role->name]['cor'] ?? 'secondary'; @endphp
                        <a href="{{ $filtro($role->name) }}"
                            class="btn btn-sm {{ $perfil === $role->name ? "btn-{$cor}" : "btn-outline-{$cor}" }}"
                            title="{{ $perfis[$role->name]['descricao'] ?? '' }}">
                            {{ ucfirst($role->name) }}
                            <span class="badge bg-light text-dark ms-1">{{ $role->users_count }}</span>
                        </a>
                    @endforeach

                    @if ($semPerfil > 0)
                        <a href="{{ $filtro('sem-perfil') }}"
                            class="btn btn-sm {{ $perfil === 'sem-perfil' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                            Sem perfil <span class="badge bg-light text-dark ms-1">{{ $semPerfil }}</span>
                        </a>
                    @endif
                </div>

                <form method="GET" action="{{ route('usuarios.index') }}" class="row g-2 mb-4">
                    @if ($perfil)
                        <input type="hidden" name="perfil" value="{{ $perfil }}">
                    @endif

                    <div class="col-md-8">
                        <input class="form-control" type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Pesquisar por nome ou e-mail...">
                    </div>

                    <div class="col-6 col-md-2 d-grid">
                        <button class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Buscar
                        </button>
                    </div>

                    <div class="col-6 col-md-2 d-grid">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-xmark me-1"></i> Limpar filtros
                        </a>
                    </div>
                </form>

                @if ($users->isEmpty())
                    <div class="alert alert-warning">
                        Nenhum usuário encontrado.
                    </div>
                @else
                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-dark">
                                <tr>
                                    <th>Usuário</th>
                                    <th>Associado</th>
                                    <th>Perfis</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($users as $user)
                                    @php
                                        $nomesPerfis = $user->roles->pluck('name');
                                        $principal = collect(array_keys($perfis))->first(fn ($p) => $nomesPerfis->contains($p));
                                        $ehVoceMesmo = $user->is(auth()->user());
                                        $ehUltimoAdmin = $nomesPerfis->contains('admin') && $totalAdmins === 1;
                                        // O perfil admin fica travado para o próprio usuário e para o último admin
                                        $travaAdmin = $nomesPerfis->contains('admin') && ($ehVoceMesmo || $ehUltimoAdmin);
                                    @endphp

                                    <tr>

                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                            @if ($ehVoceMesmo)
                                                <span class="badge bg-primary ms-1">Você</span>
                                            @endif
                                            <div class="small text-muted">{{ $user->email }}</div>
                                            @if ($principal)
                                                <span class="badge bg-{{ $perfis[$principal]['cor'] }} mt-1">
                                                    {{ ucfirst($principal) }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark border mt-1">Sem perfil</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($user->associado)
                                                {{ $user->associado->nome }}
                                                <div class="small text-muted">
                                                    CPF {{ \App\Helpers\CpfHelper::mascarar($user->associado->cpf) }}
                                                </div>
                                            @else
                                                <span class="text-muted small">Sem vínculo</span>
                                            @endif
                                        </td>

                                        <td>
                                            <form action="{{ route('usuarios.updateRole', $user->id) }}" method="POST">
                                                @csrf

                                                <div class="d-flex flex-wrap column-gap-3 row-gap-1">
                                                    @foreach ($roles as $role)
                                                        @php
                                                            $id = "role_{$user->id}_{$role->id}";
                                                            $travado = $role->name === 'admin' && $travaAdmin;
                                                        @endphp

                                                        <div class="form-check" title="{{ $perfis[$role->name]['descricao'] ?? '' }}">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="{{ $id }}" name="roles[]" value="{{ $role->name }}"
                                                                @checked($nomesPerfis->contains($role->name))
                                                                @disabled($travado)>

                                                            {{-- Checkbox desabilitado não é enviado: mantém o admin --}}
                                                            @if ($travado)
                                                                <input type="hidden" name="roles[]" value="admin">
                                                            @endif

                                                            <label class="form-check-label" for="{{ $id }}">
                                                                {{ ucfirst($role->name) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <button type="submit" class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="fa-solid fa-floppy-disk me-1"></i> Salvar perfis
                                                </button>

                                                @if ($travaAdmin)
                                                    <div class="small text-muted mt-1">
                                                        {{ $ehVoceMesmo ? 'Você não pode remover o seu próprio perfil de admin.' : 'Único admin do sistema.' }}
                                                    </div>
                                                @endif
                                            </form>
                                        </td>

                                        <td class="text-end">
                                            <div class="d-flex flex-column flex-xl-row justify-content-end gap-2">

                                                <form action="{{ route('usuarios.resetPassword', $user->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning w-100"
                                                        @disabled(!$user->associado)
                                                        title="{{ $user->associado ? 'A senha volta a ser o CPF do associado' : 'Só usuários vinculados a um associado' }}"
                                                        onclick="return confirm('A senha de {{ addslashes($user->name) }} passará a ser o CPF do associado, e a troca será exigida no próximo login. Continuar?')">
                                                        <i class="fa-solid fa-key me-1"></i> Resetar senha
                                                    </button>
                                                </form>

                                                <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                                        @disabled($ehVoceMesmo || $ehUltimoAdmin)
                                                        onclick="return confirm('Apagar o usuário {{ addslashes($user->name) }}? Esta ação não pode ser desfeita.')">
                                                        <i class="fa-solid fa-trash me-1"></i> Apagar
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-3">
                        {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>

                @endif

            </div>
        </div>

    </div>

@endsection
