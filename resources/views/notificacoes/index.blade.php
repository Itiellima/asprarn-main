@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')


    @foreach ($notificacoes as $notificacao)
        <div class="container p-3 mb-3 border bg-light">
            @if ($notificacao->lida == 0)
                <span class="badge bg-danger elementor-button">Nova</span>
            @else
                <span class="badge bg-success elementor-button">Lida</span>
            @endif
            
            <br>
            
            <strong>{{ $notificacao->id }} - {{ $notificacao->titulo }} - Data: {{ $notificacao->created_at->format('d/m/Y H:i') }}</strong> <br>
            {{ $notificacao->mensagem }} - Associado ID: {{ $notificacao->associado_id }}<br>
            
            <strong> {{ $notificacao->associado->nome }} </strong> <a class="btn btn-sm btn-primary" href="{{ route('associado.show', $notificacao->associado_id) }}">Ver detalhes</a>
            
            <form action="{{ route('notificacoes.marcarComoLida', $notificacao->id) }}" method="POST">
                @csrf
                @method('POST')

                <button type="submit" class="btn btn-primary btn-sm mt-2">{{ $notificacao->lida ? 'Marcar como não lida' : 'Marcar como lida' }}</button>

            </form>
        </div>





    @endforeach






@endsection