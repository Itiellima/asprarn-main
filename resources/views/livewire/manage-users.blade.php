<div>
    
    {{-- Success is as dangerous as failure. --}}
    <div>
    <h2>Gerenciar Usuários</h2>
    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Função</th>
            <th>Ação</th>
        </tr>

        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <button wire:click="toggleRole({{ $user->id }})">
                    {{ $user->role === 'admin' ? 'Rebaixar para User' : 'Promover para Admin' }}
                </button>
            </td>
        </tr>
        @endforeach
    </table>
</div>

</div>
