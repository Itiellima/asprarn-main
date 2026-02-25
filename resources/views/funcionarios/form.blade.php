<div class="container">

    <form action="">
        @csrf
        @method('POST')

        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o nome do funcionário"
            required value="{{ old('nome', $funcionario->nome) }}">

        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" name="cpf"
            placeholder="Insira o CPF do funcionário" required value="{{ old('cpf', $funcionario->cpf) }}">

        <label for="RG">RG:</label>
        <input type="text" class="form-control" id="RG" name="RG"
            placeholder="Insira o RG do funcionário" value="{{ old('RG', $funcionario->RG) }}">

        <label for="pis">PIS:</label>
        <input type="text" class="form-control" id="pis" name="pis"
            placeholder="Insira o PIS do funcionário" value="{{ old('pis', $funcionario->pis) }}">

        <label for="ctps">CTPS:</label>
        <input type="text" class="form-control" id="ctps" name="ctps"
            placeholder="Insira o CTPS do funcionário" value="{{ old('ctps', $funcionario->ctps) }}">

        <label for="empresa">Empresa:</label>
        <input type="text" class="form-control" id="empresa" name="empresa"
            placeholder="Insira a empresa do funcionário" value="{{ old('empresa', $funcionario->empresa) }}">

        <label for="funcao">Função:</label>
        <input type="text" class="form-control" id="funcao" name="funcao"
            placeholder="Insira a função do funcionário" value="{{ old('funcao', $funcionario->funcao) }}">

        <label for="departamento">Departamento:</label>
        <input type="text" class="form-control" id="departamento" name="departamento"
            placeholder="Insira o departamento do funcionário"
            value="{{ old('departamento', $funcionario->departamento) }}">

        <label for="atividade">Atividade:</label>
        <input type="text" class="form-control" id="atividade" name="atividade"
            placeholder="Insira a atividade do funcionário" value="{{ old('atividade', $funcionario->atividade) }}">

        <label for="horario_trabalho">Horário de Trabalho:</label>
        <input type="text" class="form-control" id="horario_trabalho" name="horario_trabalho"
            placeholder="Insira o horário de trabalho do funcionário"
            value="{{ old('horario_trabalho', $funcionario->horario_trabalho) }}">

        <label for="email_pessoal">Email Pessoal:</label>
        <input type="email" class="form-control" id="email_pessoal" name="email_pessoal"
            placeholder="Insira o E-Mail Pessoal do funcionario"
            value="{{ old('email_pessoal', $funcionario->email_pessoal) }}">

        <label for="email_profissional">Email Profissional:</label>
        <input type="email" class="form-control" id="email_profissional" name="email_profissional"
            placeholder="Insira o E-Mail Profissional do funcionário"
            value="{{ old('email_profissional', $funcionario->email_profissional) }}">

        <label for="telefone_1">Telefone 1:</label>
        <input type="text" class="form-control" id="telefone_1" name="telefone_1"
            placeholder="Insira o numero do telefone do funcionário" required
            value="{{ old('telefone_1', $funcionario->telefone_1) }}">

        <label for="telefone_2">Telefone 2:</label>
        <input type="text" class="form-control" id="telefone_2" name="telefone_2"
            placeholder="Insira o numero do telefone 2 do funcionário"
            value="{{ old('telefone_2', $funcionario->telefone_2) }}">

        <label for="endereco">Endereço:</label>
        <input type="text" class="form-control" id="endereco" name="endereco"
            placeholder="Insira o endereço do funcionário" value="{{ old('endereco', $funcionario->endereco) }}">

        <label for="data_admissao">Data de Admissão:</label>
        <input type="date" class="form-control" id="data_admissao" name="data_admissao"
            placeholder="Insira a data de admissão do funcionário"
            value="{{ old('data_admissao', $funcionario->data_admissao) }}">

        <label for="data_demissao">Data de Demissão:</label>
        <input type="date" class="form-control" id="data_demissao" name="data_demissao"
            placeholder="Insira a data de demissão do funcionário"
            value="{{ old('data_demissao', $funcionario->data_demissao) }}">

        <label for="observacoes">Observações:</label>
        <textarea class="form-control" id="observacoes" name="observacoes">{{ old('observacoes', $funcionario->observacoes) }}</textarea>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
