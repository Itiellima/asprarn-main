<?php

namespace App\Http\Controllers\Associado;

use App\Events\AssociadoCriado;
use App\Events\NotificacaoCriada;
use App\Http\Controllers\Controller;
use App\Http\Requests\Associado\AssociadoRequest;
use App\Http\Requests\Associado\StoreAssociadoRequest;
use App\Models\Associado;
use App\Models\ComoNosEncontrou;
use App\Models\Contato;
use App\Models\DadosBancarios;
use App\Models\Endereco;
use App\Models\Opm;
use App\Models\PictureProfile;
use App\Models\User;
use App\Services\IbgeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

/**
 * Cadastro de novo associado: o formulário público do site (/register)
 * e o mesmo formulário usado por admin/moderador.
 */
class CadastroController extends Controller
{
    public function create(IbgeService $ibge)
    {
        $associado = new Associado();
        $ufs = $ibge->estados();
        $opms = Opm::orderBy('nome')->get();

        return view('associado.create', compact('associado', 'ufs', 'opms'));
    }

    // Cidades de uma UF, consultadas pelo formulário ao escolher o estado
    public function cidades($uf)
    {
        $cidades = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios");

        return $cidades; // sempre retorna ARRAY de cidades
    }

    public function store(StoreAssociadoRequest $request)
    {
        DB::beginTransaction();
        try {
            $associado = Associado::create($request->only(AssociadoRequest::DADOS_PESSOAIS));

            Endereco::create($request->only(AssociadoRequest::ENDERECO) + ['associado_id' => $associado->id]);
            Contato::create($request->only(AssociadoRequest::CONTATO) + ['associado_id' => $associado->id]);
            DadosBancarios::create($request->only(AssociadoRequest::DADOS_BANCARIOS) + ['associado_id' => $associado->id]);

            // Login do associado: e-mail + CPF como senha inicial (a troca é exigida no primeiro acesso)
            $user = User::create([
                'name' => $associado->nome,
                'email' => $request->email,
                'password' => Hash::make($request->cpf),
                'associado_id' => $associado->id,
            ]);

            $user->syncRoles(['associado', 'user']);

            if ($request->hasFile('picture_profile')) {
                $path = $request->file('picture_profile')->store('picture_profiles', 'midia');
                PictureProfile::create([
                    'associado_id' => $associado->id,
                    'path' => $path,
                ]);
            }

            ComoNosEncontrou::create([
                'associado_id' => $associado->id,
                'nome' => $request->input('nome'),
                'descricao' => $request->input('como_nos_encontrou_descricao'),
                'indicacao' => $request->input('como_nos_encontrou_indicacao'),
            ]);

            DB::commit();

            event(new NotificacaoCriada([
                'titulo' => 'Novo asssociado cadastrado',
                'mensagem' => 'Novo asssociado cadastrado com sucesso, ' . $associado->nome . ' - ' . $associado->cpf,
                'associado_id' => $associado->id,
            ]));

            event(new AssociadoCriado($associado));

            $authUser = Auth::user();

            if ($authUser && $authUser->hasRole('admin|moderador')) {
                return redirect(route('associado.show', $associado->id))->with('msg', 'Associado criado com sucesso');
            } elseif (!$authUser) {
                // Cadastro público: leva ao login explicando como é o primeiro acesso
                return redirect()->route('login')->with('primeiro_acesso', $request->email);
            } else {
                return redirect('/dashboard')->with('msg', 'Associado criado com sucesso!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            report($e); // detalhe técnico vai para o log, não para a tela
            return redirect()->back()->with('error', 'Erro ao criar associado. Tente novamente.')->withInput();
        }
    }
}
