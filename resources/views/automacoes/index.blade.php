@extends('layouts.main')

@section('title', 'Envio de Mensagens via WhatsApp')

@section('content')

    <div class="container py-4">
        <form action="{{ route('automacoes.create') }}" method="POST">
            @csrf

            {{-- TÍTULO DA PÁGINA --}}
            <div class="mb-4">
                <h2 class="fw-bold">Envio de Mensagens via WhatsApp</h2>
                <p class="text-muted">
                    Utilize o formulário abaixo para enviar mensagens personalizadas via WhatsApp para os associados.
                </p>
            </div>

            {{-- FILTROS DE SELEÇÃO --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Nome da automação</h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        {{-- Situação --}}
                        <div class="col-md-4">
                            <label>
                                Nome:
                                <input type="text" name="nome" id="nome" class="form-control"
                                    placeholder="Digite o nome">
                            </label>
                        </div>
                    </div>

                </div>
            </div>



            {{-- FILTROS DE SELEÇÃO --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Filtrar Destinatários</h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        {{-- Situação --}}
                        <div class="col-md-4">
                            <label>
                                Situação:
                                <select name="situacao_id" id="situacao_id" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach ($situacoes as $situacao)
                                        <option value="{{ $situacao->id }}">{{ $situacao->nome }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                    </div>
                </div>
            </div>


            {{-- FORM DE ENVIO --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Enviar Mensagens</h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mensagem a ser enviada:</label>
                        <textarea name="mensagem" id="mensagem" class="form-control" rows="4" required></textarea>
                    </div>

                </div>
            </div>


            {{-- CONFIGURAÇÃO DE REPETIÇÃO --}}
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Agendamento e Repetição</h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-3 d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="ativo" id="ativo"
                                    class="form-check-input">
                                <label class="form-check-label fw-bold">
                                    Ativo?
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Data inicial</label>
                            <input type="date" name="data_inicio" id="data_inicio" class="form-control">
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold">Intervalo (em dias)</label>
                            <input type="number" name="intervalo_dias" id="intervalo_dias" class="form-control"
                                min="0" placeholder="Ex: 7">
                        </div>

                    </div>

                </div>
            </div>
            <button type="submit" class="btn btn-success w-100 mt-3">
                Salvar Mensagem e Agendar Envio
            </button>

        </form>
    </div>


    <div class="container">
        <h2 class="text-black text-center m-3 alert alert-light">Mensagens Agendadas</h2>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Mensagem</th>
                    <th>Situação</th>
                    <th>Data Início</th>
                    <th>Intervalo (dias)</th>
                    <th>Ativo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($automacoes as $automacao)
                    <tr>
                        <td>{{ $automacao->nome }}</td>
                        <td>{{ $automacao->mensagem }}</td>
                        <td>{{ $automacao->situacao->nome ?? 'N/A' }}</td>
                        <td>{{ $automacao->data_inicio ? $automacao->data_inicio : 'N/A' }}</td>
                        <td>{{ $automacao->intervalo_dias ?? 'N/A' }}</td>
                        <td>{{ $automacao->ativo ? 'Sim' : 'Não' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

















@endsection
