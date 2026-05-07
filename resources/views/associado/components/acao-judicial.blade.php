{{-- acao-judicial --}}
<div class="container alert alert-light text-black text-center">
    
    <strong class="text-black">
        <h2>Ações em Andamento</h2>
    </strong>

    <form action="{{ route('acao-judicial.update-acoes', $associado->id) }}" method="POST">
        @csrf

        <div class="row justify-content-center">

            @foreach ($acoes as $acao)
            <div class="col-md-3 mb-3">
                
                <div class="form-check form-check-inline">
                    <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="acao_{{ $acao->id }}" 
                    name="acoes[]"
                    value="{{ $acao->id }}" {{ $associado->acoesJudiciais->contains('id', $acao->id) ? 'checked' : '' }}>
    
                    <label class="form-check-label" for="acao_{{ $acao->id }}">
                        {{ $acao->nome }}
                    </label>
                </div>
            
            </div>
            @endforeach
        
        </div>
        
        <div class="container">
            @if ($acoes->count() > 0)
                <button type="submit" class="btn btn-primary mt-3 mb-3">Salvar</button>
            @else
                <p>Nenhuma ação judicial disponível.</p>
            @endif
        </div>

    </form>

</div>
