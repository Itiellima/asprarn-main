<div class="container">
    <div class="col-md-12">
        <h2>{{ $empresa->id ? 'Editar Empresa' : 'Cadastrar Empresa' }}</h2>
    </div>

    <form action="{{ $empresa->id ? route('empresas.update', $empresa->id) : route('empresas.store') }}"
        method="POST">
        @csrf

        @if ($empresa->id)
            @method('PUT')
        @endif

        <div class="row">

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="nome">Nome da Empresa:</label>
                <input type="text" class="form-control" id="nome" name="nome"
                    placeholder="Insira o nome da empresa"
                    value="{{ old('nome', $empresa->nome) }}" required>
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="cnpj">CNPJ:</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj"
                    placeholder="00.000.000/0000-00"
                    value="{{ old('cnpj', $empresa->cnpj) }}">
            </div>

            <div class="col-md-12 col-sm-12 mb-3">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" name="endereco"
                    placeholder="Insira o endereço da empresa"
                    value="{{ old('endereco', $empresa->endereco) }}">
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone"
                    placeholder="(00) 00000-0000"
                    value="{{ old('telefone', $empresa->telefone) }}">
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="telefone_2">Telefone 2:</label>
                <input type="text" class="form-control" id="telefone_2" name="telefone_2"
                    placeholder="(00) 00000-0000"
                    value="{{ old('telefone_2', $empresa->telefone_2) }}">
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="Insira o email"
                    value="{{ old('email', $empresa->email) }}">
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="email_2">Email 2:</label>
                <input type="email" class="form-control" id="email_2" name="email_2"
                    placeholder="Insira o segundo email"
                    value="{{ old('email_2', $empresa->email_2) }}">
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="tipo_convenio">Tipo de Convênio:</label>
                <input type="text" class="form-control" id="tipo_convenio" name="tipo_convenio"
                    placeholder="Ex: Desconto, parceria, serviço"
                    value="{{ old('tipo_convenio', $empresa->tipo_convenio) }}">
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="horario_trabalho">Horário de Trabalho:</label>
                <input type="text" class="form-control" id="horario_trabalho" name="horario_trabalho"
                    placeholder="Ex: 08:00 às 18:00"
                    value="{{ old('horario_trabalho', $empresa->horario_trabalho) }}">
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="data_inicio_contrato">Data Início do Contrato:</label>
                <input type="date" class="form-control" id="data_inicio_contrato" name="data_inicio_contrato"
                    value="{{ old('data_inicio_contrato', $empresa->data_inicio_contrato) }}">
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="data_fim_contrato">Data Fim do Contrato:</label>
                <input type="date" class="form-control" id="data_fim_contrato" name="data_fim_contrato"
                    value="{{ old('data_fim_contrato', $empresa->data_fim_contrato) }}">
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="funcionarios">Quantidade de Funcionários:</label>
                <input type="number" class="form-control" id="funcionarios" name="funcionarios"
                    placeholder="Número de funcionários"
                    value="{{ old('funcionarios', $empresa->funcionarios) }}">
            </div>

            <div class="col-md-12 col-sm-12 mb-3">
                <label for="observacoes">Observações:</label>
                <textarea class="form-control" id="observacoes" name="observacoes">{{ old('observacoes', $empresa->observacoes) }}</textarea>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>


@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {

        $('#cnpj').mask('00.000.000/0000-00');

        $('#telefone').mask('(00) 00000-0000');

        $('#telefone_2').mask('(00) 00000-0000');

    });
</script>

@endpush