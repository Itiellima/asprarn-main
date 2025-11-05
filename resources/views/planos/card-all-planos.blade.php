<div class="container">
    @foreach ($planos as $plano)
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">{{ $plano->nome }}</h4>
            <p>
                <strong>
                    Valor: R$ {{ number_format($plano->preco, 2, ',', '.') }}
                </strong>
            </p>
            <hr>
            <p class="">
                <strong>
                    *Descrição do plano*
                    {{ $plano->descricao }}
                </strong>
            </p>
            <hr>
            <button class="btn btn-secondary m-1">
                Editar Plano
            </button>
            <form action="{{ route('planos.destroy', $plano->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger m-1" onclick="return confirm('Tem certeza que deseja excluir este plano?')">
                    Excluir Plano
                </button>
            </form>
        </div>
    @endforeach


</div>
