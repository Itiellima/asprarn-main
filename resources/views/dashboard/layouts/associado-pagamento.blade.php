
{{-- Aba meus pagamentos --}}
<div class="alert alert-light">
    <h4 class="text-black">Meus Pagamentos</h4>

    <a href="{{ route('dashboard.associado.financeiro') }}">
        <button class="btn btn-primary mb-3">💵 Pagar Mensalidade</button>
    </a>

    {{-- remover futuramente --}}
    <h3>
        Tabela exemplificativa de pagamentos realizados
    </h3>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data de pagamento</th>
                <th>Mes de referencia</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>dd/mm/yy</td>
                <td>Janeiro</td>
                <td>
                    <button class="btn btn-primary m-2">Verificar pagamento</button>
                    <button class="btn btn-primary m-2">Emitir 2ª via</button>
                </td>
            </tr>
        </tbody>
    </table>

</div>
