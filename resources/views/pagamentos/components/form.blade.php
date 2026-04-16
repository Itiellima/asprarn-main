<div class="container">
    <h3>Editar Pagamento</h3>

    <form action="{{ $pagamento->id ? route('pagamentos.update', $pagamento->id) : route('pagamentos.store') }}"
        method="POST">
        @csrf
        @if ($pagamento->id)
            @method('PUT')
        @else
            @method('POST')
        @endif

        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="text" class="form-control" id="valor" name="valor"
                value="{{ old('valor', number_format($pagamento->valor, 2, ',', '.')) }}" required>
        </div>

        <div class="mb-3">
            <label for="data_pagamento" class="form-label">Data de Pagamento</label>
            <input type="date" class="form-control" id="data_pagamento" name="data_pagamento"
                value="{{ old('data_pagamento', $pagamento->data_pagamento->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="mes_referencia" class="form-label">Mês de Referência</label>
            <input type="month" class="form-control" id="mes_referencia" name="mes_referencia"
                value="{{ old('mes_referencia', $pagamento->mes_referencia->format('Y-m')) }}" required>
        </div>

        <div class="mb-3">
            <label for="metodo_pagamento" class="form-label">Método de Pagamento</label>
            <select class="form-select" id="metodo_pagamento" name="metodo_pagamento" required>
                <option value=""
                    {{ old('metodo_pagamento', $pagamento->metodo_pagamento) === '' ? 'selected' : '' }}>
                    Selecione um método de pagamento</option>
                <option value="boleto"
                    {{ old('metodo_pagamento', $pagamento->metodo_pagamento) === 'boleto' ? 'selected' : '' }}>Boleto
                </option>
                <option value="cartao"
                    {{ old('metodo_pagamento', $pagamento->metodo_pagamento) === 'cartao' ? 'selected' : '' }}>Cartão de
                    Crédito</option>
                <option value="pix"
                    {{ old('metodo_pagamento', $pagamento->metodo_pagamento) === 'pix' ? 'selected' : '' }}>Pix</option>
                <option value="dinheiro"
                    {{ old('metodo_pagamento', $pagamento->metodo_pagamento) === 'dinheiro' ? 'selected' : '' }}>
                    Dinheiro
                </option>
                <option value="desconto_em_folha" {{ old('metodo_pagamento', $pagamento->metodo_pagamento) === 'desconto_em_folha' ? 'selected' : '' }}>
                    Desconto em folha
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="" {{ old('tipo', $pagamento->tipo) === '' ? 'selected' : '' }}>
                    Selecione um tipo</option>
                <option value="mensalidade" {{ old('tipo', $pagamento->tipo) === 'mensalidade' ? 'selected' : '' }}>
                    Mensalidade
                </option>
                <option value="anuidade" {{ old('tipo', $pagamento->tipo) === 'anuidade' ? 'selected' : '' }}>Anuidade
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="" {{ old('status', $pagamento->status) === '' ? 'selected' : '' }}>
                    Selecione um status</option>
                <option value="pendente" {{ old('status', $pagamento->status) === 'pendente' ? 'selected' : '' }}>
                    Pendente
                </option>
                <option value="pago" {{ old('status', $pagamento->status) === 'pago' ? 'selected' : '' }}>Pago
                </option>
                <option value="atrasado" {{ old('status', $pagamento->status) === 'atrasado' ? 'selected' : '' }}>
                    Atrasado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="numero_documento" class="form-label">Número do Documento</label>
            <input type="text" class="form-control" id="numero_documento" name="numero_documento"
                value="{{ old('numero_documento', $pagamento->numero_documento) }}">
        </div>

        <div class="mb-3">
            <label for="origem" class="form-label">Origem</label>
            <input type="text" class="form-control" id="origem" name="origem"
                value="{{ old('origem', $pagamento->origem) }}">
        </div>

        <div class="mb-3">
            <label for="observacao" class="form-label">Observação</label>
            <textarea class="form-control" id="observacao" name="observacao">{{ old('observacao', $pagamento->observacao) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>



@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- Aplica as máscaras -->
    <script>
        $(document).ready(function() {
            $('#valor').mask('#.##0,00', {
                reverse: true
            });
        });
    </script>
@endpush
