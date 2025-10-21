@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')
    @include('layouts.nav-dashboard')

    <div class="container">
        <h1>Gerenciar permissões dos Usuários</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div id="search-container" class="col-md-12 mb-3">
            <label for="form-label">Busque um associado</label>
            <form method="GET" action="{{ route('usuarios.index') }}">
                <input class="form-control" type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Pesquisar...">
            </form>

        </div>

        @if (!@empty($search))
            <p>Você pesquisou por: <strong>{{ $search }}</strong></p>
        @else
        @endif

        @if ($users->isEmpty())
            <p>Nenhum usuario encontrado.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Role Principal</th>
                        <th>Alterar Role</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            // Pega a role principal baseado na hierarquia
                            if ($user->hasRole('admin')) {
                                $principal = 'admin';
                            } elseif ($user->hasRole('moderador')) {
                                $principal = 'moderador';
                            } elseif ($user->hasRole('associado')) {
                                $principal = 'associado';
                            } else {
                                $principal = 'user';
                            }
                        @endphp
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($principal) }}</td>
                            <td>
                                <form action="{{ route('usuarios.updateRole', $user->id) }}" method="POST">
                                    @csrf
                                    @foreach ($roles as $role)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" 
                                                id="role_{{ $role->id }}"
                                                name="roles[]" 
                                                value="{{ $role->name }}"
                                                {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ ucfirst($role->name) }}
                                            </label>
                                        </div>
                                    @endforeach

                                    <button type="submit" class="btn btn-sm btn-primary mt-1">Salvar</button>
                                </form>

                            </td>
                            <td>
                                <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mt-1"
                                        onclick="return confirm('Tem certeza que deseja deletar este usuário?')">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        @endif
    </div>

@endsection
