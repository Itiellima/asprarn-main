<?php

namespace App\Policies;

use App\Models\Associado;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Quem pode mexer nos dados de um associado específico.
 *
 * Admin e moderador acessam qualquer associado; o associado acessa só o próprio cadastro.
 * As telas do painel (lista, edição, exclusão) já são barradas pelo grupo de rotas
 * em routes/web/admin.php; esta policy cobre as rotas da área do associado,
 * que só exigem login e recebem o id na URL.
 */
class AssociadoPolicy
{
    /** Ver informações e carteirinhas */
    public function view(User $user, Associado $associado): Response
    {
        return $this->somenteDonoOuGestor($user, $associado);
    }

    /** Enviar ou remover a foto de perfil */
    public function alterarFoto(User $user, Associado $associado): Response
    {
        return $this->somenteDonoOuGestor($user, $associado);
    }

    private function somenteDonoOuGestor(User $user, Associado $associado): Response
    {
        if ($user->hasRole(['admin', 'moderador'])) {
            return Response::allow();
        }

        if ($user->hasRole('associado') && (string) $user->associado_id === (string) $associado->id) {
            return Response::allow();
        }

        return Response::deny('Acesso negado.');
    }
}
