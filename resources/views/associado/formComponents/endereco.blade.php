<div class="container row border-bottom border-primary mt-3 m-1">
    <div class="mb-3 col-md-3 col-sm-6">
        <label for="formGroup" class="form-label">CEP:
        </label>
        <input class="form-control" name="cep" type="text" id="cep" placeholder="Apenas números"
            value="{{ old('cep', $associado->endereco?->cep) }}" maxlength="9" onblur="pesquisacep(this.value);" />
    </div>

    <div class="mb-3 col-md-9 col-sm-6">
        <label for="formGroup" class="form-label">Logradouro:
        </label>
        <input class="form-control" name="logradouro" type="text" id="logradouro" placeholder="Rua.."
            value="{{ old('logradouro', $associado->endereco?->logradouro) }}" />
    </div>

    <div class="mb-3 col-md-3 col-sm-6">
        <label for="formGroup" class="form-label">Bairro:
        </label>
        <input class="form-control" name="bairro" type="text" id="bairro" placeholder="Nome do bairro"
            value="{{ old('bairro', $associado->endereco?->bairro) }}" />
    </div>

    <div class="mb-3 col-md-3 col-sm-6">
        <label for="formGroup" class="form-label">Cidade:
        </label>
        <input class="form-control" name="cidade" type="text" id="cidade" placeholder="Nome da cidade"
            value="{{ old('cidade', $associado->endereco?->cidade) }}" />
    </div>

    <div class="mb-3 col-md-3 col-sm-6">
        <label for="formGroup" class="form-label">Estado:
        </label>
        <input class="form-control" name="uf" type="text" id="uf" placeholder="UF"
            value="{{ old('estado', $associado->endereco?->estado) }}" />
    </div>

    <div class="mb-3 col-md-3 col-sm-6">
        <label for="formGroup" class="form-label">Número:
        </label>
        <input class="form-control" name="nmr" type="text" id="nmr"
            value="{{ old('nmr', $associado->endereco?->nmr) }}" placeholder="Número da residencia" />
    </div>
    <div class="mb-3 col-md-12 col-sm-12">
        <label for="formGroup" class="form-label">Complemento:</label>
        <input type="text" class="form-control " id="complemento" name="complemento"
            placeholder="Ponto de referência" value="{{ old('complemento', $associado->endereco?->complemento) }}">
    </div>

</div>

@push('scripts')
    <script>
        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('logradouro').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('logradouro').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {

            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('logradouro').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };
    </script>
@endpush
