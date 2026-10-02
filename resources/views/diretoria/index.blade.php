@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container py-4">

        {{-- Cabeçalho --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="mb-1">Diretorias</h2>
                <p class="text-muted mb-0">
                    Conheça e gerencie as diretorias da ASPRA-RN.
                </p>
            </div>

            <a href="{{ route('diretoria.create') }}" class="btn btn-warning">
                <i class="bi bi-plus-lg me-1"></i>
                Nova diretoria
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
                                <th scope="col">Sigla</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($diretorias as $dir)
                                <tr>
                                    <td class="ps-4 fw-semibold">
                                        {{ $dir->nome }}
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $dir->sigla }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($dir->status === 'ativo')
                                            <span class="badge bg-success">
                                                Ativa
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($dir->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex gap-2">

                                            <a href="{{ route('diretoria.edit', $dir->id) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil me-1"></i>
                                                Editar
                                            </a>

                                            <form action="{{ route('diretoria.destroy', $dir->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Deseja excluir a diretoria {{ $dir->nome }}? Ao excluir uma diretoria, todos os membros vinculados a ela serão excluídos!');">
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
                                            <i class="bi bi-building fs-2 d-block mb-2"></i>
                                            <p class="mb-2">Nenhuma diretoria cadastrada.</p>

                                            <a href="{{ route('diretoria.create') }}" class="btn btn-sm btn-warning">
                                                Cadastrar primeira diretoria
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
