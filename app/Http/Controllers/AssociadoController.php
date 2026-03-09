<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use App\Events\NotificacaoCriada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Associado;
use App\Models\Contato;
use App\Models\Endereco;
use App\Models\DadosBancarios;
use App\Models\Opm;
use App\Models\Situacao;
use App\Models\PictureProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


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

        $cidades = Associado::with('endereco')
            ->get()
            ->pluck('endereco.cidade')
            ->unique()
            ->sort()
            ->values();

        $opms = Associado::select('opm')
            ->pluck('opm')
            ->unique()
            ->sort()
            ->values();

        $associados = Associado::query()
            ->with(['endereco', 'situacoes'])

            // Filtro por texto
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                        ->orWhere('cpf', 'like', "%{$search}%")
                        ->orWhere('matricula', 'like', "%{$search}%");
                });
            })

            // Filtro por cidade
            ->when(request('cidade'), function ($query, $cidade) {
                $query->whereHas('endereco', function ($q) use ($cidade) {
                    $q->where('cidade', $cidade);
                });
            })

            // Filtro por OPM
            ->when(request('opm'), function ($query, $opm) {
                $query->where('opm', $opm);
            })

            // Filtro por situação
            ->when(request('situacao'), function ($query, $situacao_id) {
                $query->whereHas('situacoes', function ($q) use ($situacao_id) {
                    $q->where('situacoes.id', $situacao_id);
                });
            })


            ->paginate(12)
            ->appends(request()->query()); // mantém filtros na paginação

        $totalAssociados = Associado::count();
        $situacoes = Situacao::all();

        return view('associado.index', ['associados' => $associados, 'search' => $search, 'totalAssociados' => $totalAssociados, 'cidades' => $cidades, 'opms' => $opms, 'situacoes' => $situacoes]);
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
        ])->findOrFail($id);

        $contato = $associado->contato ?? new Contato();
        $endereco = $associado->endereco ?? new Endereco();
        $dadosBancarios = $associado->dadosBancarios ?? new DadosBancarios();

        $situacoes = Situacao::all();

        return view('associado.show', compact('associado', 'contato', 'endereco', 'dadosBancarios', 'situacoes'));
    }

    // view para criar um associado
    public function create()
    {
        $associado = new Associado();

        // Buscar UFs do IBGE
        $ufs = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
            ->json();

        $ufs = collect($ufs)->sortBy('nome')->values()->all();

        $opms = Opm::orderBy('nome')->get();

        return view('associado.create', compact('associado', 'ufs', 'opms'));
    }

    // Rota para buscar cidades por UF via IBGE
    public function cidades($uf)
    {
        $cidades = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios");

        return $cidades; // sempre retorna ARRAY de cidades
    }


    // Rota salvar o associado no banco de dados
    public function store(Request $request)
    {

        // 1. Remove mascaras antes de validar
        $request->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf),
            'tel_celular' => preg_replace('/[^0-9]/', '', $request->tel_celular),
            'tel_residencial' => preg_replace('/[^0-9]/', '', $request->tel_residencial),
            'tel_trabalho' => preg_replace('/[^0-9]/', '', $request->tel_trabalho),
        ]);


        // 2. Validação
        $request->validate([
            'nome'  => 'required',
            'cpf'   => 'required|unique:associados,cpf|digits:11',
            'email' => 'required|unique:users,email',
        ], [
            'cpf.unique'   => 'Já existe um associado cadastrado com esse CPF.',
            'cpf.digits'     => 'O CPF deve conter exatamente 11 dígitos numericos.',
            'email.unique' => 'Já existe um associado com esse e-mail.',
        ]);

        if (!\App\Helpers\CpfHelper::validar($request->cpf)) {
            return redirect()->back()->with('error', 'CPF inválido.')->withInput();
        }

        DB::beginTransaction();
        try {
            // 3. Cria associado
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

            // 4. Cria endereço
            Endereco::create($request->only([
                'cep',
                'logradouro',
                'nmr',
                'bairro',
                'cidade',
                'uf',
                'complemento'
            ]) + ['associado_id' => $associado->id]);

            // 5. Cria contato
            Contato::create($request->only([
                'tel_celular',
                'tel_residencial',
                'tel_trabalho',
                'email'
            ]) + ['associado_id' => $associado->id]);

            // 6. Cria dados bancários
            DadosBancarios::create($request->only([
                'codigo',
                'agencia',
                'banco',
                'conta',
                'operacao',
                'tipo'
            ]) + ['associado_id' => $associado->id]);

            // 7. Cria usuário
            $user = User::create([
                'name'         => $associado->nome,
                'email'        => $request->email,
                'password'     => Hash::make($request->cpf),
                'associado_id' => $associado->id,
            ]);

            $user->syncRoles(['associado', 'user']);

            DB::commit();

            $data = [
                'titulo' => 'Novo asssociado cadastrado',
                'mensagem' => 'Novo asssociado cadastrado com sucesso, ' . $associado->nome . ' - ' . $associado->cpf,
                'associado_id' => $associado->id,
            ];

            event(new NotificacaoCriada($data));

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

        // Buscar UFs do IBGE
        $ufs = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
            ->json();

        $opms = Opm::orderBy('nome')->get();

        return view('associado.create', compact('associado', 'ufs', 'opms'));
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
                ])
            );

            // Atualiza o contato
            $associado->contato()->updateOrCreate(
                ['associado_id' => $associado->id],
                $request->only([
                    'tel_celular',
                    'tel_residencial',
                    'tel_trabalho',
                    'email'
                ])
            );

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
                ])
            );
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
            if ($associado->user) {
                $associado->user->delete();
            }

            // Exclui o associado (cascade cuida do resto)
            $associado->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao deletar associado : ' . $e->getMessage());
        }

        return redirect('/associado')->with('msg', 'Associado deletado com sucesso!');
    }

    public function storePictureProfile(Request $request, $associadoId)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('associado|admin|moderador')) {
            return redirect()->route('associado.index')
                ->with('error', 'Acesso negado.');
        }

        $associado = Associado::findOrFail($associadoId);

        $request->validate([
            'picture_profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        $newPath = null;

        try {
            // 1️⃣ salva o arquivo
            $newPath = $request->file('picture_profile')
                ->store('picture_profiles', 'public');

            // 2️⃣ pega a antiga
            $oldPicture = PictureProfile::where('associado_id', $associado->id)->first();

            // 3️⃣ cria ou atualiza
            PictureProfile::updateOrCreate(
                ['associado_id' => $associado->id],
                ['path' => $newPath]
            );

            // 4️⃣ apaga a antiga só se for diferente
            if ($oldPicture && $oldPicture->path !== $newPath) {
                if (Storage::disk('public')->exists($oldPicture->path)) {
                    Storage::disk('public')->delete($oldPicture->path);
                }
            }

            DB::commit();

            return back()->with('msg', 'Foto de perfil atualizada com sucesso!');
        } catch (\Exception $e) {

            DB::rollBack();

            // 🔥 evita arquivo órfão
            if ($newPath && Storage::disk('public')->exists($newPath)) {
                Storage::disk('public')->delete($newPath);
            }

            return back()->with('error', 'Erro ao atualizar foto.');
        }
    }

    public function destroyPictureProfile($associadoId)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('associado|admin|moderador')) {
            return redirect()->route('associado.index')
                ->with('error', 'Acesso negado.');
        }

        $picture = PictureProfile::where('associado_id', $associadoId)->first();

        DB::beginTransaction();
        try {

            if ($picture) {

                // apaga o arquivo físico
                if (Storage::disk('public')->exists($picture->path)) {
                    Storage::disk('public')->delete($picture->path);
                }

                // apaga o registro no banco
                $picture->delete();
                DB::commit();
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao deletar foto.');
        }

        return back()->with('msg', 'Foto de perfil deletada com sucesso!');
    }

    public function showCarteirinha($id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('associado|admin|moderador')) {
            return redirect()->route('associado.index')
                ->with('error', 'Acesso negado.');
        }

        $associado = Associado::with(['endereco', 'contato', 'dadosBancarios'])->findOrFail($id);

        return view('dashboard.associadoComponents.carteirinha-download', compact('associado'));

    }
}