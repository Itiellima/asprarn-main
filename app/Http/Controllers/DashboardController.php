<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Associado;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        // Usuario conectado
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Usuario não autenticado.');
        }

        // Roles do usuário
        $userRoles = $user->roles->pluck('name')->toArray();

        // Prioridade de roles: só escolhe a tela inicial, não muda o que cada um pode acessar.
        // Financeiro vem antes de associado: quem trabalha no financeiro e também é associado
        // entra direto no trabalho e chega aos próprios dados pelo menu.
        $priority = ['admin', 'moderador', 'financeiro', 'associado'];

        // Pega a role com maior prioridade
        $role = collect($priority)->first(fn($r) => in_array($r, $userRoles));

        if (!$role) {
            abort(403, 'Acesso negado.');
        }

        return match ($role) {
            'admin', 'moderador' => $this->adminDashboard($user),
            'financeiro' => redirect()->route('financeiro.index'),
            'associado' => $this->associadoDashboard($user),
            default => abort(403, 'Acesso negado.'),
        };
    }


    private function adminDashboard($user)
    {
        $totalAssociados = Associado::count();

        $situacoes = DB::table('situacoes')
            ->select('situacoes.id', 'situacoes.nome', DB::raw('COUNT(associado_situacao.associado_id) as total'))
            ->leftJoin('associado_situacao', 'situacoes.id', '=', 'associado_situacao.situacao_id')
            ->groupBy('situacoes.id', 'situacoes.nome')
            ->get();


        $ano = now()->year;

        $associadosPorMes = DB::table('associados')
            ->selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', $ano)
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        $labelsMes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 
                      'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

        $dadosMes = [];

        for ($i = 1; $i <= 12; $i++) {
            $dadosMes[] = $associadosPorMes[$i] ?? 0;
        }


        return view("dashboard.admin", compact('user', 'totalAssociados', 'situacoes', 'dadosMes', 'labelsMes', 'ano'));
    }

    private function associadoDashboard($user)
    {
        $associado = $user->associado;
        if (!$associado) {
            abort(403, 'Acesso negado.');
        }

        $pagamentos = $associado->pagamentos()
            ->orderBy('data_pagamento', 'desc')
            ->paginate(10);

        
        return view('dashboard.associado', compact('user', 'associado', 'pagamentos'));
    }
}
