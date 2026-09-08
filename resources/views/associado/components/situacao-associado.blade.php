<div class="container mb-3">
    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white text-center py-2">
            <strong>Situação do associado</strong>
        </div>

        <div class="card-body">

            <form action="{{ route('situacao.update', $associado->id) }}" method="POST">
                @csrf

                <div class="row g-2">
                    @foreach ($situacoes as $situacao)
                        <div class="col-6 col-md-3">
                            <label class="border rounded p-2 w-100 d-flex align-items-center gap-2">
                                <input
                                    class="form-check-input m-0"
                                    type="checkbox"
                                    name="situacoes[]"
                                    value="{{ $situacao->id }}"
                                    {{ $associado->situacoes->contains($situacao->id) ? 'checked' : '' }}>

                                <span>{{ $situacao->nome }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>

                @if ($situacoes->count())
                    <div class="text-center mt-3">
                        <button class="btn btn-primary btn-sm px-4">
                            Salvar
                        </button>
                    </div>
                @else
                    <p class="text-muted text-center mb-0">
                        Nenhuma situação disponível.
                    </p>
                @endif

            </form>

        </div>
    </div>
</div>