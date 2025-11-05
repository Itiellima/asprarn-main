<div class="container">
    @foreach ($planos as $plano)
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">{{ $plano->nome }}</h4>
            <p>
                @foreach ($plano->beneficios as $beneficio)
                    -{{ $beneficio }}
                    <br>
                @endforeach
                <strong>
                    Valor: R$ {{ number_format($plano->preco, 2, ',', '.') }}
                </strong>
            </p>
            <hr>
            <p class="">
                <strong>
                    {{ $plano->descricao }}
                </strong>
            </p>
            <hr>

            <a href="{{ route('planos.edit', $plano->id) }}" class="btn btn-primary m-1">Editar plano
            </a>

            <form action="{{ route('planos.destroy', $plano->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger m-1"
                    onclick="return confirm('Tem certeza que deseja excluir este plano?')">
                    Excluir Plano
                </button>
            </form>
        </div>
    @endforeach


</div>
