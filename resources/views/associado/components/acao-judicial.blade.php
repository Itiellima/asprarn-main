<div class="container mb-3">
    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white text-center py-2">
            <strong>Ações em andamento</strong>
        </div>

        <div class="card-body">

            <form action="{{ route('acao-judicial.update-acoes', $associado->id) }}" method="POST">
                @csrf

                <div class="row g-2">
                    @foreach ($acoes as $acao)
                        <div class="col-6 col-md-3">
                            <label class="border rounded p-2 w-100 d-flex align-items-center gap-2">
                                <input
                                    class="form-check-input m-0"
                                    type="checkbox"
                                    name="acoes[]"
                                    value="{{ $acao->id }}"
                                    {{ $associado->acoesJudiciais->contains('id', $acao->id) ? 'checked' : '' }}>

                                <span>{{ $acao->nome }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>

                @if ($acoes->count())
                    <div class="text-center mt-3">
                        <button class="btn btn-primary btn-sm px-4">
                            Salvar
                        </button>
                    </div>
                @else
                    <p class="text-muted text-center mb-0">
                        Nenhuma ação judicial disponível.
                    </p>
                @endif

            </form>

        </div>
    </div>
</div>