@extends('layouts.main')

@section('title', 'Envio de Mensagens via WhatsApp')

@section('content')

    <div class="container py-4">

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

                    {{-- Associado --}}
                    {{-- <div class="col-md-6">
                        <label>
                            Associado:
                            <select name="associado_id" id="associado_id" class="form-control">
                                <option value="">Selecione</option>
                                @foreach ($associados as $associado)
                                    <option value="{{ $associado->id }}" data-situacao="{{ $associado->situacao_id }}">
                                        {{ $associado->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div> --}}

                </div>

            </div>
        </div>


        {{-- FORM DE ENVIO --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Enviar Mensagens</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('whatsapp.enviarMensagens') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mensagem a ser enviada:</label>
                        <textarea name="mensagem" id="mensagem" class="form-control" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Enviar mensagens
                    </button>

                </form>

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
                            <input type="checkbox" name="repetir_mensagem" id="repetir_mensagem" class="form-check-input">
                            <label class="form-check-label fw-bold">
                                Repetir mensagem?
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Data inicial</label>
                        <input type="date" name="data_repeticao" id="data_repeticao" class="form-control">
                    </div>

                    <div class="col-md-5">
                        <label class="form-label fw-bold">Intervalo (em dias)</label>
                        <input type="number" name="dias_repeticao" id="dias_repeticao" class="form-control" min="1"
                            placeholder="Ex: 7">
                    </div>

                </div>

            </div>
        </div>

    </div>


@endsection
