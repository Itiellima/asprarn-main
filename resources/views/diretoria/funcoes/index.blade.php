@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container py-4">

        {{-- Cabeçalho --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="mb-1">Funções</h2>
                <p class="text-muted mb-0">
                    Conheça e gerencie as funções das diretorias da ASPRA-RN.
                </p>
            </div>

            <a href="{{ route('diretoria.funcoes.create') }}" class="btn btn-warning">
                <i class="bi bi-plus-lg me-1"></i>
                Nova função
            </a>
        </div>

        {{-- Tabela --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">

                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="ps-4">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($funcoes as $funcao)
                                <tr>
                                    <td class="ps-4 fw-semibold">
                                        {{ $funcao->nome }}
                                    </td>

                                    <td>
                                        <span class="text-muted">
                                            {{ $funcao->descricao ?: 'Sem descrição' }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($funcao->status === 'ativo')
                                            <span class="badge bg-success">
                                                Ativa
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($funcao->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex gap-2">

                                            <a href="{{ route('diretoria.funcoes.edit', $funcao->id) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil me-1"></i>
                                                Editar
                                            </a>

                                            <form action="{{ route('diretoria.funcoes.destroy', $funcao->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Deseja excluir a função {{ $funcao->nome }}? Ao excluir uma função, todos os membros vinculados a ela serão excluídos!');">
                                                    <i class="bi bi-trash me-1"></i>
                                                    Excluir
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-briefcase fs-2 d-block mb-2"></i>

                                            <p class="mb-2">
                                                Nenhuma função cadastrada.
                                            </p>

                                            <a href="{{ route('diretoria.funcoes.create') }}"
                                                class="btn btn-sm btn-warning">
                                                Cadastrar primeira função
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
