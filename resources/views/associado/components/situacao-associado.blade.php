{{-- situacao --}}
<div class="container alert alert-light text-black text-center">
    
    <strong class="text-black">
        <h2>Situação do associado</h2>
    </strong>

    <form action="{{ route('situacao.update', $associado->id) }}" method="POST">
        @csrf

        @foreach ($situacoes as $situacao)
            <div class="form-check form-check-inline">
                <input 
                class="form-check-input" 
                type="checkbox" 
                id="situacao_{{ $situacao->id }}" 
                name="situacoes[]"
                value="{{ $situacao->id }}" {{ $associado->situacoes->contains($situacao->id) ? 'checked' : '' }}>

                <label class="form-check-label" for="situacao_{{ $situacao->id }}">
                    {{ $situacao->nome }}
                </label>
            </div>
        @endforeach
        
        @if ($situacoes->count() > 0)
            <button type="submit" class="btn btn-primary mt-3 mb-3">Salvar</button>
        @else

        @endif

    </form>

</div>
