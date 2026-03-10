@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')
    @include('dashboard.layouts.nav-dashboard')

    <div class="container mt-4">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Gerenciar Permissões dos Usuários</h5>
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif


                <form method="GET" action="{{ route('usuarios.index') }}" class="row g-2 mb-4">

                    <div class="col-md-10">
                        <input class="form-control" type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Pesquisar usuário por nome ou email...">
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary">
                            🔍 Buscar
                        </button>
                    </div>

                </form>

                @if (!empty($search))
                    <p class="mb-3">Resultado da busca por:
                        <strong>{{ $search }}</strong>
                    </p>
                @endif


                @if ($users->isEmpty())

                    <div class="alert alert-warning">
                        Nenhum usuário encontrado.
                    </div>
                @else
                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Role Principal</th>
                                    <th>Permissões</th>
                                    <th width="200">Ações</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($users as $user)
                                    @php
                                        if ($user->hasRole('admin')) {
                                            $principal = 'admin';
                                            $badge = 'danger';
                                        } elseif ($user->hasRole('moderador')) {
                                            $principal = 'moderador';
                                            $badge = 'warning';
                                        } elseif ($user->hasRole('associado')) {
                                            $principal = 'associado';
                                            $badge = 'success';
                                        } else {
                                            $principal = 'user';
                                            $badge = 'secondary';
                                        }
                                    @endphp

                                    <tr>

                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                        </td>

                                        <td>
                                            {{ $user->email }}
                                        </td>

                                        <td>
                                            <span class="badge bg-{{ $badge }}">
                                                {{ ucfirst($principal) }}
                                            </span>
                                        </td>

                                        <td>

                                            <form action="{{ route('usuarios.updateRole', $user->id) }}" method="POST">
                                                @csrf

                                                <div class="d-flex flex-wrap gap-2">

                                                    @foreach ($roles as $role)
                                                        <div class="form-check">

                                                            <input class="form-check-input" type="checkbox"
                                                                id="role_{{ $user->id }}_{{ $role->id }}"
                                                                name="roles[]" value="{{ $role->name }}"
                                                                {{ $user->hasRole($role->name) ? 'checked' : '' }}>

                                                            <label class="form-check-label">
                                                                {{ ucfirst($role->name) }}
                                                            </label>

                                                        </div>
                                                    @endforeach

                                                </div>

                                                <button type="submit" class="btn btn-sm btn-primary mt-2">
                                                    Salvar
                                                </button>

                                            </form>

                                        </td>

                                        <td>

                                            <div class="d-flex gap-2">

                                                <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Tem certeza que deseja deletar este usuário?')">

                                                        Deletar
                                                    </button>

                                                </form>

                                                <form action="{{ route('usuarios.resetPassword', $user->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button class="btn btn-sm btn-warning">
                                                        Resetar senha
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
