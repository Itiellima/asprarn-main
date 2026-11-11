<?php

namespace App\Http\Controllers;

use App\Http\Requests\Associado\AssociadoRequest;
use App\Http\Requests\Associado\UpdateAssociadoRequest;
use App\Models\AcaoJudicial;
use App\Models\Associado;
use App\Models\Contato;
use App\Models\DadosBancarios;
use App\Models\Endereco;
use App\Models\Opm;
use App\Models\Situacao;
use App\Models\User;
use App\Services\IbgeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Associados no painel (admin/moderador): lista, ficha, edição, exclusão e reset de senha.
 * Cadastro, carteirinha, foto e "Meus Dados" ficam em Controllers/Associado/.
 */
class AssociadoController extends Controller
{
    // view todos os associados
    public function index()
    {
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
        $acoes = AcaoJudicial::all();

        return view('associado.index', ['associados' => $associados, 'search' => $search, 'totalAssociados' => $totalAssociados, 'cidades' => $cidades, 'opms' => $opms, 'situacoes' => $situacoes, 'acoes' => $acoes]);
    }

    // view detalhes informaçoes
    public function show($id)
    {
        $associado = Associado::with([
            'endereco',
            'contato',
            'dadosBancarios',
            'historicoSituacoes',
            'mensalidades',
            'acoesJudiciais',
            'situacoes',
        ])->findOrFail($id);

        $contato = $associado->contato ?? new Contato();
        $endereco = $associado->endereco ?? new Endereco();
        $dadosBancarios = $associado->dadosBancarios ?? new DadosBancarios();

        $situacoes = Situacao::all();
        $acoes = AcaoJudicial::all();

        return view('associado.show', compact('associado', 'contato', 'endereco', 'dadosBancarios', 'situacoes', 'acoes'));
    }

    // view edição do associado (mesmo formulário do cadastro)
    public function edit($id, IbgeService $ibge)
    {
        $associado = Associado::findOrFail($id);
        $ufs = $ibge->estados();
        $opms = Opm::orderBy('nome')->get();

        return view('associado.create', compact('associado', 'ufs', 'opms'));
    }

    public function update(UpdateAssociadoRequest $request, $id)
    {
        $associado = Associado::with(['endereco', 'contato', 'dadosBancarios', 'comoNosEncontrou'])->findOrFail($id);

        DB::beginTransaction();
        try {
            $associado->update($request->only(AssociadoRequest::DADOS_PESSOAIS));

            $associado->endereco()->updateOrCreate(
                ['associado_id' => $associado->id],
                $request->only(AssociadoRequest::ENDERECO)
            );

            $associado->contato()->updateOrCreate(
                ['associado_id' => $associado->id],
                $request->only(AssociadoRequest::CONTATO)
            );

            // O e-mail da ficha é também o login: mantém os dois iguais (o perfil faz o caminho inverso)
            $loginAlterado = false;
            if ($associado->user && $request->filled('email') && $request->email !== $associado->user->email) {
                $associado->user->forceFill(['email' => $request->email])->save();
                $loginAlterado = true;
            }

            $associado->dadosBancarios()->updateOrCreate(
                ['associado_id' => $associado->id],
                $request->only(AssociadoRequest::DADOS_BANCARIOS)
            );

            $associado->comoNosEncontrou()->updateOrCreate(
                ['associado_id' => $associado->id],
                [
                    'nome' => $request->input('nome'),
                    'descricao' => $request->input('como_nos_encontrou_descricao'),
                    'indicacao' => $request->input('como_nos_encontrou_indicacao'),
                ]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao atualizar associado')->withInput();
        }

        $mensagem = 'Associado alterado com sucesso!';
        if ($loginAlterado) {
            $mensagem .= ' O e-mail de login também foi alterado.';
        }

        return redirect()->route('associado.show', $associado->id)->with('msg', $mensagem);
    }

    // Deletar associado
    public function destroy($id)
    {
        $associado = Associado::findOrFail($id);

        if ($associado->pagamentos()->exists()) {
            return redirect()->back()->with('error', 'Não é possível deletar o associado, pois ele possui pagamentos vinculados.');
        }

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
            report($e); // detalhe técnico vai para o log, não para a tela
            return redirect()->back()->with('error', 'Erro ao deletar associado. Tente novamente.');
        }

        return redirect('/associado')->with('msg', 'Associado deletado com sucesso!');
    }

    public function resetPassword($id)
    {
        $user = Auth::user();

        $associado = Associado::findOrFail($id);

        // Só admin pode resetar a senha de outro admin
        if ($associado->user && $associado->user->hasRole('admin') && !$user->hasRole('admin')) {
            return redirect()->back()->with('error', 'Apenas administradores podem resetar a senha de um administrador.');
        }

        $cpf = preg_replace('/\D/', '', $associado->cpf);

        if ($associado->user) {
            $associado->user->update([
                'password' => Hash::make($cpf)
            ]);
        } else {
            $usuario = User::create([
                'name' => $associado->nome,
                'email' => $associado->contato->email ?? $cpf . '@temp.com',
                'password' => Hash::make($cpf),
                'associado_id' => $associado->id,
            ]);

            $usuario->syncRoles(['associado', 'user']);
        }

        return redirect()->back()->with('success', 'Senha resetada para o CPF do associado.');
    }
}
