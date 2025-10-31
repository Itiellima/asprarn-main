@extends('layouts.main')

@section('title', '')

@section('content')

    @include('layouts.nav-dashboard')

    <div class="container">

        <p>Usuario - {{ $user->name }}</p>

        <div class="alert alert-light">
            <h4 class="text-black">Meus Benefícios</h4>

            <ul>
                <li>Desconto em parceiros comerciais</li>
                <li>Acesso a eventos exclusivos</li>
                <li>Newsletter mensal com novidades</li>
            </ul>
            <a href="#">
                <button class="btn btn-primary mb-3">📝 Solicitar Novo Benefício</button>
            </a>
        </div>

        <div class="alert alert-light">
            <h4 class="text-black">Meu plano</h4>
            <p>Plano Atual: Básico</p>
            <p>Vencimento: 30/12/2024</p>
            <a href="#">
                <button class="btn btn-primary mb-3">🔄 Alterar Plano</button>
            </a>
        </div>

        {{-- Aba meus pagamentos --}}
        <div class="alert alert-light">
            <h4 class="text-black">Meus Pagamentos</h4>

            <a href="#">
                <button class="btn btn-primary mb-3">💵 Pagar Mensalidade</button>
            </a>


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
                            <button>Verificar pagamento</button>
                            <button>Emitir 2ª via</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>




    </div>
@endsection
