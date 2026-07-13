@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Contas a pagar
@endsection

@section('financeiro-content')
    <div class="container rounded">
        <a href="{{ route('contas-a-pagar.create') }}" class="btn btn-primary">
            Nova conta a pagar
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Data do lançamento</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Conta</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contas as $conta)
                    <tr style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#modalConta{{ $conta->id }}">
                        <td>{{ $conta->id }}</td>
                        <td>{{ ucfirst($conta->tipo) }}</td>
                        <td>{{ number_format($conta->valor, 2, ',', '.') }}</td>
                        <td>{{ date('d/m/Y', strtotime($conta->data_lancamento)) }}</td>
                        <td>{{ $conta->categoria->nome ?? 'Nenhuma' }}</td>
                        <td>{{ $conta->conta->nome ?? 'Nenhuma' }}</td>
                        <td>
                            {{ $conta->situacao === 'pago' ? 'Pago' :  ($conta->situacao === 'cancelado' ? 'Cancelado' : 'Pendente')}}<br>    
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="modalConta{{ $conta->id }}" tabindex="-1" aria-labelledby="modalContaLabel{{ $conta->id }}"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalContaLabel{{ $conta->id }}">Detalhes da Conta a Pagar</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <strong>ID:</strong> {{ $conta->id }}<br>
                                    <strong>Tipo:</strong> {{ ucfirst($conta->tipo) }}<br>
                                    <strong>Valor:</strong> {{ number_format($conta->valor, 2, ',', '.') }}<br>
                                    <strong>Data do Lançamento:</strong>
                                    {{ date('d/m/Y', strtotime($conta->data_lancamento)) }}<br>
                                    <strong>Categoria:</strong> {{ $conta->categoria->nome ?? 'Nenhuma' }}<br>
                                    <strong>Conta:</strong> {{ $conta->conta->nome ?? 'Nenhuma' }}<br>
                                    <strong>Situação:</strong> {{ ucfirst($conta->situacao) }}<br>
                                    <strong>Data de Pagamento:</strong> {{ $conta->data_pagamento ? date('d/m/Y', strtotime($conta->data_pagamento)) : 'Não informado' }}<br>
                                    <strong>Descrição:</strong> {{ $conta->descricao ?? 'Nenhuma' }}<br>
                                    <strong>Observação:</strong> {{ $conta->observacao ?? 'Nenhuma' }}
                                </div>
                                <div class="modal-footer">

                                    <a href="{{ route('contas-a-pagar.edit', $conta->id) }}"
                                        class="btn btn-warning">
                                        Editar
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
