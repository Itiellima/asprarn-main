<div class="container">
    <div class="col-md-12">
        <h2>{{ $prestador->id ? 'Editar Prestador de Serviços' : 'Cadastrar Prestador de Serviços' }}</h2>
    </div>

    <form action="{{ $prestador->id ? route('prestador-de-servicos-autonomos.update', $prestador->id) : route('prestador-de-servicos-autonomos.store') }}"
        method="POST">
        @csrf

        @if ($funcionario->id)
            @method('PUT')
        @else
            @method('POST')
        @endif

        <div class="row">

            <div class="col-md-6 col sm-12 mb-3">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome"
                    placeholder="Insira o nome do funcionário" required value="{{ old('nome', $prestador->nome) }}" />
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf"
                    placeholder="Insira o CPF do funcionário" required value="{{ old('cpf', $prestador->cpf) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="RG">RG:</label>
                <input type="text" class="form-control" id="rg" name="rg"
                    placeholder="Insira o RG do funcionário" value="{{ old('rg', $prestador->rg) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="empresa">Empresa:</label>
                <input type="text" class="form-control" id="empresa" name="empresa"
                    placeholder="Insira a empresa do funcionário" value="{{ old('empresa', $prestador->empresa) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="funcao">Função:</label>
                <input type="text" class="form-control" id="funcao" name="funcao"
                    placeholder="Insira a função do funcionário" value="{{ old('funcao', $prestador->funcao) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="departamento">Departamento:</label>
                <input type="text" class="form-control" id="departamento" name="departamento"
                    placeholder="Insira o departamento do funcionário"
                    value="{{ old('departamento', $prestador->departamento) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="atividade">Atividade:</label>
                <input type="text" class="form-control" id="atividade" name="atividade"
                    placeholder="Insira a atividade do funcionário"
                    value="{{ old('atividade', $prestador->atividade) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="email_pessoal">Email Pessoal:</label>
                <input type="email" class="form-control" id="email_pessoal" name="email_pessoal"
                    placeholder="Insira o E-Mail Pessoal do funcionario"
                    value="{{ old('email_pessoal', $prestador->email_pessoal) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="email_profissional">Email Profissional:</label>
                <input type="email" class="form-control" id="email_profissional" name="email_profissional"
                    placeholder="Insira o E-Mail Profissional do funcionário"
                    value="{{ old('email_profissional', $prestador->email_profissional) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="telefone_1">Telefone 1:</label>
                <input type="text" class="form-control" id="telefone_1" name="telefone_1"
                    placeholder="(00) 00000-0000" required value="{{ old('telefone_1', $prestador->telefone_1) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="telefone_2">Telefone 2:</label>
                <input type="text" class="form-control" id="telefone_2" name="telefone_2"
                    placeholder="(00) 00000-0000" value="{{ old('telefone_2', $prestador->telefone_2) }}">
            </div>

            <div class="col-md-12 col sm-12 mb-3">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" name="endereco"
                    placeholder="Insira o endereço do funcionário"
                    value="{{ old('endereco', $prestador->endereco) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="data_admissao">Data de Admissão:</label>
                <input type="date" class="form-control" id="data_admissao" name="data_admissao"
                    placeholder="Insira a data de admissão do funcionário"
                    value="{{ old('data_admissao', $prestador->data_admissao) }}">
            </div>

            <div class="col-md-6 col sm-12 mb-3">
                <label for="data_demissao">Data de Demissão:</label>
                <input type="date" class="form-control" id="data_demissao" name="data_demissao"
                    placeholder="Insira a data de demissão do funcionário"
                    value="{{ old('data_demissao', $prestador->data_demissao) }}">
            </div>

            <div class="col-md-12 col sm-12 mb-3">
                <label for="observacoes">Observações:</label>
                <textarea class="form-control" id="observacoes" name="observacoes">{{ old('observacoes', $prestador->observacoes) }}</textarea>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>


@push('scripts')
    <!-- 2️⃣ Carrega o plugin de máscara -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- 3️⃣ Aplica as máscaras -->
    <script>
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00');
            $('#telefone_1').mask('(00) 00000-0000');
            $('#telefone_2').mask('(00) 00000-0000');
        });
    </script>
@endpush
