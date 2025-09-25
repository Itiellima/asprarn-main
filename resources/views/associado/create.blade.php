@extends('layouts.main')

@section('title', 'Novo associado')

@section('content')

<div class="container body-offset">
    
    @if ($associado->id)
        <h1>Editar associado</h1>
    @else
        <h1>Cadastrar novo associado</h1>
    @endif
    
    
    <div class="container mb-3">
        <div class="container">
    
            <fieldset id="formFields" @if ($associado->id) disabled @endif>
                <form action="{{ $associado->id ? route('associado.update', $associado->id) : route('associado.store') }}"
                    method="POST">
                    @csrf
                    @if ($associado->id)
                        @method('PUT')
                    @endif
    
    
                    {{-- DADOS PESSOAIS --}}
                    <div class="container row m-1 border-bottom border-primary">
                        <h2>Dados pessoais</h2>
                        <div class="mb-3 col-6">
                            <label for="formGroup" class="form-label">Nome:</label>
                            <input type="text" class="form-control " id="nome" name="nome"
                                placeholder="Insira o nome do associado" required
                                value="{{ old('nome', $associado->nome) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">CPF:</label>
                            <input type="text" class="form-control " id="cpf" name="cpf"
                                placeholder="Insira o CPF do associado" required value="{{ old('cpf', $associado->cpf) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">RG:</label>
                            <input type="text" class="form-control " id="rg" name="rg"
                                placeholder="Insira o numero do RG" required value="{{ old('rg', $associado->rg) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Órgão expedidor:</label>
                            <input type="text" class="form-control " id="org_expedidor" name="org_expedidor"
                                placeholder="Órgão expedidor" required
                                value="{{ old('org_expedidor', $associado->org_expedidor) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Nome do pai:</label>
                            <input type="text" class="form-control " id="nome_pai" name="nome_pai"
                                placeholder="Insira o nome do pai" value="{{ old('nome_pai', $associado->nome_pai) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Nome da Mãe:</label>
                            <input type="text" class="form-control " id="nome_mae" name="nome_mae"
                                placeholder="Insira o nome da mãe" value="{{ old('nome_mae', $associado->nome_mae) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Data de nascimento</label>
                            <input type="date" class="form-control " id="dt_nasc" name="dt_nasc" required
                                value="{{ old('dt_nasc', $associado->dt_nasc) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Estado civil:</label>
                            <select class="form-select " name="estado_civil" id="estado_civil" required>
                                <option value="">Selecione</option>
                                <option value="solteiro"
                                    {{ old('estado_civil', $associado->estado_civil) == 'solteiro' ? 'selected' : '' }}>
                                    Solteiro
                                </option>
                                <option value="casado"
                                    {{ old('estado_civil', $associado->estado_civil) == 'casado' ? 'selected' : '' }}>Casado
                                </option>
                                <option
                                    value="uniao_estavel {{ old('estado_civil', $associado->estado_civil) == 'uniao_estavel' ? 'selected' : '' }}">
                                    Uniao Estavel</option>
                                <option value="divorciado"
                                    {{ old('estado_civil', $associado->estado_civil) == 'divorciado' ? 'selected' : '' }}>
                                    Divorciado
                                </option>
                                <option value="viuvo"
                                    {{ old('estado_civil', $associado->estado_civil) == 'viuvo' ? 'selected' : '' }}>Viuvo
                                </option>
                                <option value="outro"
                                    {{ old('estado_civil', $associado->estado_civil) == 'outro' ? 'selected' : '' }}>Outro
                                </option>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Grau de Instrução:</label>
                            <select class="form-select " name="grau_instrucao" id="grau_instrucao" required>
                                <option selected value="">Selecione</option>
                                <option value="fundamental_completo"
                                    {{ old('grau_instrucao', $associado->grau_instrucao) == 'fundamental_completo' ? 'selected' : '' }}>
                                    Ensino
                                    fundamental completo</option>
                                <option value="fundamental_incompleto"
                                    {{ old('grau_instrucao', $associado->grau_instrucao) == 'fundamental_incompleto' ? 'selected' : '' }}>
                                    Ensino
                                    fundamental incompleto</option>
                                <option value="medio_completo"
                                    {{ old('grau_instrucao', $associado->grau_instrucao) == 'medio_completo' ? 'selected' : '' }}>
                                    Ensino médio completo
                                </option>
                                <option value="medio_incompleto"
                                    {{ old('grau_instrucao', $associado->grau_instrucao) == 'medio_incompleto' ? 'selected' : '' }}>
                                    Ensino médio
                                    incompleto</option>
                                <option value="superior_completo"
                                    {{ old('grau_instrucao', $associado->grau_instrucao) == 'superior_completo' ? 'selected' : '' }}>
                                    Ensino superior
                                    completo</option>
                                <option value="superior_incompleto"
                                    {{ old('grau_instrucao', $associado->grau_instrucao) == 'superior_incompleto' ? 'selected' : '' }}>
                                    Ensino superior
                                    incompleto</option>
                                <option value="pos_graduacao"
                                    {{ old('pos_graduacao', $associado->grau_instrucao) == 'pos_graduacao' ? 'selected' : '' }}>
                                    Pós-graduação</option>
                                <option value="mestrado"
                                    {{ old('mestrado', $associado->grau_instrucao) == 'mestrado' ? 'selected' : '' }}>
                                    Mestrado
                                </option>
                                <option value="doutorado"
                                    {{ old('doutorado', $associado->grau_instrucao) == 'doutorado' ? 'selected' : '' }}>
                                    Doutorado
                                </option>
                            </select>
                        </div>
                    </div>
    
                    {{-- Endereço --}}
                    <div class="container row border-bottom border-primary mt-3 m-1">
                        <h2>Endereço</h2>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">CEP:</label>
                            <input type="number" class="form-control " id="cep" name="cep"
                                placeholder="59000-000 apenas numeros" required
                                value="{{ old('cep', $associado->endereco?->cep) }}">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="formGroup" class="form-label">Logradouro:</label>
                            <input type="text" class="form-control " id="logradouro" name="logradouro"
                                placeholder="Rua..." required
                                value="{{ old('logradouro', $associado->endereco?->logradouro) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Numero:</label>
                            <input type="text" class="form-control " id="nmr" name="nmr"
                                placeholder="Número da residência" required
                                value="{{ old('nmr', $associado->endereco?->nmr) }}">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="formGroup" class="form-label">Bairro:</label>
                            <input type="text" class="form-control " id="bairro" name="bairro"
                                placeholder="Insira o nome do bairro" required
                                value="{{ old('bairro', $associado->endereco?->bairro) }}">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="formGroup" class="form-label">Cidade:</label>
                            <input type="text" class="form-control " id="cidade" name="cidade"
                                placeholder="Insira o nome da cidade" required
                                value="{{ old('cidade', $associado->endereco?->cidade) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">UF:</label>
                            <input type="text" class="form-control " id="uf" name="uf"
                                placeholder="ex: RN" required value="{{ old('uf', $associado->endereco?->uf) }}">
                        </div>
                        <div class="mb-3 col-9">
                            <label for="formGroup" class="form-label">Complemento:</label>
                            <input type="text" class="form-control " id="complemento" name="complemento"
                                placeholder="Ponto de referência"
                                value="{{ old('complemento', $associado->endereco?->complemento) }}">
                        </div>
                    </div>
    
                    {{-- Contato --}}
                    <div class="container row border-bottom border-primary mt-3 m-1">
                        <h2>Contato</h2>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Numero de Celular:</label>
                            <input type="text" class="form-control" maxlength="11" pattern="\d{10,11}"
                                id="tel_celular" name="tel_celular" placeholder="(xx) x xxxx-xxxx  Apenas numero"
                                required value="{{ old('tel_celular', $associado->contato?->tel_celular) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Numero Residencial:</label>
                            <input type="text" class="form-control" maxlength="11" pattern="\d{10,11}"
                                id="tel_residencial" name="tel_residencial" placeholder="(xx) x xxxx-xxxx  Apenas numero"
                                value="{{ old('tel_residencial', $associado->contato?->tel_residencial) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Numero de Trabalho:</label>
                            <input type="text" class="form-control" maxlength="11" pattern="\d{10,11}"
                                id="tel_trabalho" name="tel_trabalho" placeholder="(xx) x xxxx-xxxx  Apenas numero"
                                value="{{ old('tel_trabalho', $associado->contato?->tel_trabalho) }}">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="formGroup" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="exemplo@email.com" required
                                value="{{ old('email', $associado->contato?->email) }}">
                        </div>
                    </div>
    
                    {{-- Dados Bancarios --}}
                    <div class="container row border-bottom border-primary mt-3 m-1">
                        <h2>Dados Bancarios</h2>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Codigo:</label>
                            <input type="number" class="form-control" id="codigo" name="codigo"
                                placeholder="Insira o código do banco" 
                                value="{{ old('codigo', $associado->dadosBancarios?->codigo) }}">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="formGroup" class="form-label">Agencia:</label>
                            <input type="number" class="form-control" id="agencia" name="agencia"
                                placeholder="Insira o número da agência" 
                                value="{{ old('agencia', $associado->dadosBancarios?->agencia) }}">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="formGroup" class="form-label">Banco:</label>
                            <input type="text" class="form-control" id="banco" name="banco"
                                placeholder="Insira o nome do banco" 
                                value="{{ old('banco', $associado->dadosBancarios?->banco) }}">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="formGroup" class="form-label">Conta:</label>
                            <input type="number" class="form-control" id="conta" name="conta"
                                placeholder="Insira o número da conta" 
                                value="{{ old('conta', $associado->dadosBancarios?->conta) }}">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="formGroup" class="form-label">Operação:</label>
                            <input type="number" class="form-control" id="operacao" name="operacao"
                                placeholder="Insira o número da operação" 
                                value="{{ old('operacao', $associado->dadosBancarios?->operacao) }}">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="formGroup" class="form-label">Tipo:</label>
                            <input type="text" class="form-control" id="tipo" name="tipo"
                                placeholder="Insira o tipo da conta" 
                                value="{{ old('tipo', $associado->dadosBancarios?->tipo) }}">
                        </div>
                    </div>
    
                    {{-- Dados dos Militares --}}
                    <div class="container row border-bottom border-primary mt-3 m-1">
                        <h2>Dados dos Militares</h2>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">Posto/Graduação:</label>
                            <select class="form-select " name="graduacao" id="graduacao">
                                <option selected value="">Selecione</option>
                                <option value="civil"
                                    {{ old('civil', $associado->graduacao) == 'civil' ? 'selected' : '' }}>
                                    Civil</option>
                                <option value="soldado"
                                    {{ old('soldado', $associado->graduacao) == 'soldado' ? 'selected' : '' }}>Soldado
                                </option>
                                <option value="cabo"
                                    {{ old('cabo', $associado->graduacao) == 'cabo' ? 'selected' : '' }}>
                                    Cabo</option>
                                <option value="3_sargento"
                                    {{ old('3_sargento', $associado->graduacao) == '3_sargento' ? 'selected' : '' }}>3°
                                    Sargento</option>
                                <option value="2_sargento"
                                    {{ old('2_sargento', $associado->graduacao) == '2_sargento' ? 'selected' : '' }}>2°
                                    Sargento</option>
                                <option value="1_sargento"
                                    {{ old('1_sargento', $associado->graduacao) == '1_sargento' ? 'selected' : '' }}>1°
                                    Sargento</option>
                                <option value="subtenente"
                                    {{ old('subtenente', $associado->graduacao) == 'subtenente' ? 'selected' : '' }}>
                                    Subtenente
                                </option>
                            </select>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="formGroup" class="form-label">Nome de Guerra:</label>
                            <input type="text" class="form-control" id="nome_guerra" name="nome_guerra"
                                placeholder="Insira o nome de guerra" required
                                value="{{ old('nome_guerra', $associado->nome_guerra) }}">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="formGroup" class="form-label">Numero de praça:</label>
                            <input type="text" class="form-control" id="nmr_praca" name="nmr_praca"
                                placeholder="Insira o número de praça" required
                                value="{{ old('nmr_praca', $associado->nmr_praca) }}">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="formGroup" class="form-label">Matricula:</label>
                            <input type="text" class="form-control" id="matricula" name="matricula"
                                placeholder="Insira a matrícula" required
                                value="{{ old('matricula', $associado->matricula) }}">
                        </div>
                        <div class="mb-3 col-3">
                            <label for="formGroup" class="form-label">OPM:</label>
                            <select class="form-select " name="opm" id="opm">
                                <option selected value="">Selecione</option>
                                <option value="1bpm" {{ old('1bpm', $associado->opm) == '1bpm' ? 'selected' : '' }}>
                                    1°BPM
                                </option>
                            </select>
                        </div>
                    </div>
    
                    {{-- Dependentes e Observações --}}
                    <div class="container row border-bottom border-primary mt-3 m-1">
                        <h2>Dependentes</h2>
                        <label for="formGroup" class="form-label">Insira os nomes dos dependentes:</label>
                        <textarea name="dependentes" id="dependentes" cols="30" rows="5" maxlength="200">{{ old('dependentes', $associado->dependentes) }}</textarea>
                        </textarea>
                    </div>
    
                    {{-- Observações --}}
                    <div class="container row border-bottom border-primary mt-3 m-1">
                        <h2>Observações</h2>
                        <label for="formGroup" class="form-label">Insira os nomes dos dependentes:</label>
                        <textarea name="obs" id="obs" cols="30" rows="5" maxlength="200">{{ old('obs', $associado->obs) }}</textarea>
                        </textarea>
                    </div>
    
                    <div class="container border-bottom border-primary mt-3 text-end">
                        <input type="submit" class="btn btn-primary mb-3" id="submitBtn"
                            value="{{ $associado->id ? 'Salvar alterações' : 'Cadastrar' }}">
                    </div>
                </form>
            </fieldset>
            <div class="container row mt-3 text-end">
                @hasanyrole('admin|editor')
                @if ($associado->id)
                    <form action="{{ route('associado.destroy', $associado->id) }}" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja excluir este associado? {{ $associado->nome }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir Associado</button>
                        <button type="button" id="enableEdit" class="btn btn-warning">Habilitar Edição</button>
                    </form>
                @endif
            @endhasanyrole
            
            </div>
            
        </div>
    </div>
    
</div>
<script src="{{ asset('js/form-edit.js') }}"></script>

@endsection
