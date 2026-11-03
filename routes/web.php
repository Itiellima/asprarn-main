<?php

// As rotas ficam separadas pelo nível de acesso. Cada arquivo tem um único grupo de
// middleware, então uma rota nova já nasce com a proteção do arquivo onde for colocada:
//
//   web/publico.php    -> sem login (site, cadastro, verificação da carteirinha)
//   web/associado.php  -> login, qualquer perfil (o controller confere se o dado é do próprio associado)
//   web/admin.php      -> login + admin ou moderador (e um bloco só para admin)
//   web/financeiro.php -> login + admin ou financeiro
//   web/diretoria.php  -> login + admin
//
// O teste tests/Feature/RotasProtegidasTest.php falha se uma rota ficar sem proteção
// sem estar na lista de rotas públicas.

require __DIR__ . '/web/publico.php';
require __DIR__ . '/web/associado.php';
require __DIR__ . '/web/admin.php';
require __DIR__ . '/web/financeiro.php';
require __DIR__ . '/web/diretoria.php';
