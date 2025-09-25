<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Associado;
use App\Models\Contato;
use App\Models\Endereco;
use App\Models\DadosBancarios;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AssociadoController extends Controller
{
    // view todos os associados
    public function index()
    {

        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }


        $search = request('search');

        $associados = Associado::query()
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('cpf', 'like', "%{$search}%")
                    ->orWhere('matricula', 'like', "%{$search}%");
            })
            ->orderBy('nome')
            ->paginate(10);


        return view('associado.index', ['associados' => $associados, 'search' => $search]);
    }


    // view detalhes informaçoes
    public function show($id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('associado.index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::with([
            'endereco',
            'contato',
            'dadosBancarios',
            'historicoSituacoes',
            'mensalidades',
            'situacao'
        ])->findOrFail($id);

        $contato = $associado->contato ?? new Contato();
        $endereco = $associado->endereco ?? new Endereco();
        $dadosBancarios = $associado->dadosBancarios ?? new DadosBancarios();


        return view('associado.show', compact('associado', 'contato', 'endereco', 'dadosBancarios'));
    }

    // view para criar um associado
    public function create()
    {
        $associado = new Associado();

        return view('associado.create', ['associado' => $associado]);
    }

    // Rota salvar o associado no banco de dados
    public function store(Request $request)
    {
        // 1. Validação
        $request->validate([
            'nome'  => 'required',
            'cpf'   => 'required|unique:associados,cpf',
            'email' => 'required|unique:users,email',
        ], [
            'cpf.unique'   => 'Já existe um associado cadastrado com esse CPF.',
            'email.unique' => 'Já existe um usuário com esse e-mail.',
        ]);

        if (!\App\Helpers\CpfHelper::validar($request->cpf)) {
            return redirect()->back()->with('error', 'CPF inválido.')->withInput();
        }

        DB::beginTransaction();
        try {
            // 2. Cria associado
            $associado = Associado::create($request->only([
                'nome',
                'cpf',
                'rg',
                'org_expedidor',
                'nome_pai',
                'nome_mae',
                'dt_nasc',
                'estado_civil',
                'grau_instrucao',
                'graduacao',
                'nome_guerra',
                'nmr_praca',
                'matricula',
                'opm',
                'dependentes',
                'obs'
            ]));

            // 3. Cria endereço
            Endereco::create($request->only([
                'cep',
                'logradouro',
                'nmr',
                'bairro',
                'cidade',
                'uf',
                'complemento'
            ]) + ['associado_id' => $associado->id]);

            // 4. Cria contato
            Contato::create($request->only([
                'tel_celular',
                'tel_residencial',
                'tel_trabalho',
                'email'
            ]) + ['associado_id' => $associado->id]);

            // 5. Cria dados bancários
            DadosBancarios::create($request->only([
                'codigo',
                'agencia',
                'banco',
                'conta',
                'operacao',
                'tipo'
            ]) + ['associado_id' => $associado->id]);

            // 6. Cria usuário
            $user = User::create([
                'name'         => $associado->nome,
                'email'        => $request->email,
                'password'     => Hash::make('123456'),
                'associado_id' => $associado->id,
            ]);

            $user->syncRoles(['associado', 'user']);

            DB::commit();
            return redirect('/dashboard')->with('msg', 'Associado criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao criar associado: ' . $e->getMessage())->withInput();
        }
    }


    // view edição do associado
    public function edit($id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::findOrFail($id);

        return view('associado.create', ['associado' => $associado]);
    }

    // Rota para atualizar o associado no banco de dados
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('associado.index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::with(['endereco', 'contato', 'dadosBancarios'])->findOrFail($id);

        DB::beginTransaction();
        try {
            // Atualiza os dados da tabela principal
            $associado->update($request->only([
                'nome',
                'cpf',
                'rg',
                'org_expedidor',
                'nome_pai',
                'nome_mae',
                'dt_nasc',
                'estado_civil',
                'grau_instrucao',
                'graduacao',
                'nome_guerra',
                'nmr_praca',
                'matricula',
                'opm',
                'dependentes',
                'obs'
            ]));

            // Atualiza o endereço (assume que o relacionamento existe)
            $associado->endereco()->updateOrCreate(
                ['associado_id' => $associado->id],
                $request->only([
                'cep',
                'logradouro',
                'nmr',
                'bairro',
                'cidade',
                'uf',
                'complemento'
            ]));

            // Atualiza o contato
            $associado->contato()->updateOrCreate(
                ['associado_id' => $associado->id],
                $request->only([
                'tel_celular',
                'tel_residencial',
                'tel_trabalho',
                'email'
            ]));

            // Atualiza os dados bancários
            $associado->dadosBancarios()->updateOrCreate(
                ['associado_id' => $associado->id],
                $request->only([
                'codigo',
                'agencia',
                'banco',
                'conta',
                'operacao',
                'tipo'
            ]));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao atualizar associado');
        }

        return redirect('/associado')->with('msg', 'Associado alterado com sucesso!');
    }


    // Deletar associado
    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('associado.index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::findOrFail($id);

        try {
            DB::beginTransaction();

            // Exclui o usuário vinculado ao associado (se existir)
            $associado->user->delete();

            // Exclui o associado (cascade cuida do resto)
            $associado->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao deletar associado');
        }

        return redirect('/associado')->with('msg', 'Associado deletado com sucesso!');
    }
}
