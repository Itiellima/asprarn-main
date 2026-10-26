# ASPRARN – Sistema de Gestão

Sistema web da **Associação de Praças da Polícia Militar do Rio Grande do Norte (ASPRARN)**. Reúne o site público da associação e o painel administrativo usado pela equipe para gerir associados, documentos, financeiro, diretoria e comunicação.

## Módulos

**Site público**
- Página inicial com banners, notícias (posts), eventos, benefícios e feed do Instagram
- Quem somos, perguntas frequentes e contato

**Painel administrativo**
- **Associados** – cadastro completo (dados pessoais, endereço, contato, dados bancários, OPM), situações e histórico, planos, foto de perfil
- **Documentos** – pastas e arquivos por associado, geração de PDFs (fichas, declarações, procurações, requerimentos)
- **Ações judiciais** – cadastro de ações e vínculo com associados
- **Pagamentos** – mensalidades e importação de pagamentos
- **Financeiro** – categorias, contas bancárias, lançamentos, contas a pagar/receber e extrato
- **Diretoria** – mandatos, funções e membros
- **Funcionários, empresas e prestadores de serviço autônomos**
- **Sorteios** – participantes e resultados
- **Automações e notificações** – mensagens de WhatsApp agendadas por situação do associado (via webhook n8n)
- **Relatórios**
- **Usuários e permissões** – perfis `admin`, `moderador`, `associado` e `user`

## Tecnologias

| Camada | Stack |
|---|---|
| Backend | PHP 8.2+, Laravel 12, Livewire 3 |
| Autenticação | Jetstream + Fortify (com 2FA), Sanctum |
| Permissões | spatie/laravel-permission |
| Documentos | Páginas HTML impressas pelo navegador (`resources/views/associado/pdf`) |
| Frontend | Blade, Vite 7, Tailwind CSS, Bootstrap Icons, TinyMCE |
| Banco de dados | MySQL 8 |
| Armazenamento | Disco local/public (suporte a S3 disponível) |
| PWA | ladumor/laravel-pwa |
| Infra | Docker: imagem única com Nginx + PHP-FPM 8.4 + worker da fila |

## Requisitos

- PHP 8.2+ com as extensões `gd`, `zip`, `pdo_mysql`, `bcmath`, `mbstring`
- Composer 2
- Node.js 20.19+ (exigido pelo Vite 7)
- MySQL 8

Ou apenas **Docker** e **Docker Compose**.

## Instalação local

```bash
git clone https://github.com/Itiellima/asprarn-main.git
cd asprarn-main

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Ajuste o banco no `.env` (o `.env.example` vem configurado para o Docker, com `DB_HOST=db`):

```env
DB_HOST=127.0.0.1
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

Depois:

```bash
php artisan migrate --seed
php artisan storage:link
composer run dev
```

`composer run dev` sobe o servidor, a fila, os logs (Pail) e o Vite ao mesmo tempo. Acesse http://localhost:8000.

## Executando com Docker

O `docker-compose.yml` sobe a **mesma imagem de produção** e um MySQL, para testar localmente:

```bash
docker compose up -d --build
```

Acesse http://localhost:8080. O compose lê o seu `.env` (precisa ter `APP_KEY`) e sobrescreve só o banco. O MySQL fica exposto na porta **3307**, porque a 3306 costuma estar ocupada pelo XAMPP.

Comandos úteis:

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app php artisan tinker
docker compose logs -f app
```

O compose também sobe um **SeaweedFS** local. Na primeira vez, crie os buckets:

```bash
docker compose exec seaweedfs sh -c 'echo "s3.bucket.create -name documentos" | weed shell'
docker compose exec seaweedfs sh -c 'echo "s3.bucket.create -name midia" | weed shell'
```

## Deploy em produção (Easypanel)

Produção roda como **App** no Easypanel, com build pelo **Dockerfile** deste repositório. O deploy é **manual**: o push na `main` não dispara nada.

### O que roda no container

| Processo | Função |
|---|---|
| Nginx | Recebe as requisições na porta 80 |
| PHP-FPM 8.4 | Roda o Laravel |
| `queue:work` | Processa a fila `database` (boas-vindas, notificações) |

O **MySQL** e os arquivos (**SeaweedFS**) ficam em serviços separados. O container não guarda nada que precise sobreviver a um deploy, então não precisa de volume. O agendador roda pelo **n8n**, que chama `/api/automacoes/executar`.

A cada início do container, o `docker/entrypoint.sh`:

1. Confere se a `APP_KEY` existe (se não existir, o container não sobe).
2. Cria as pastas do `storage` e roda `storage:link`.
3. Roda as migrations, **somente** se `RUN_MIGRATIONS=true`. Seed nunca roda.
4. Roda `php artisan optimize`, que gera o cache de config, rotas, eventos e views.

### Configuração no Easypanel

- **Build:** Dockerfile (caminho `Dockerfile`).
- **Porta:** 80.
- **Health check:** `/up`.

### Variáveis de ambiente

Ficam na aba **Environment** do app, nunca dentro da imagem (o `.dockerignore` bloqueia qualquer `.env`). Depois de alterar uma variável, basta **reiniciar** o app: o `optimize` do entrypoint lê os valores novos. Não precisa de novo build.

Como a config fica em cache, o código só deve ler variáveis por `config(...)`, nunca por `env(...)` fora da pasta `config/`.

| Variável | Observação |
|---|---|
| `APP_KEY` | Obrigatória e **fixa**. Se mudar, todos são deslogados e os dados criptografados ficam ilegíveis. |
| `APP_ENV=production`, `APP_DEBUG=false` | |
| `RUN_MIGRATIONS` | `true` roda `migrate --force` ao iniciar. Padrão: desligado. |
| `LOG_STACK=single,stderr` | Recomendado: os erros aparecem também nos logs do Easypanel. |
| `QUEUE_CONNECTION=database` | Processada pelo worker do container. |

### Limites

- Upload: 10 MB por arquivo e 20 MB por requisição (`docker/php.ini` e `docker/nginx.conf`). As fotos de perfil também são reduzidas no navegador antes do envio (`public/js/redimensionar-foto.js`).

## Financeiro

Tudo fica numa tabela só, `financeiro_lancamentos`. As regras estão em `app/Services/Financeiro/LancamentoService.php`.

| Tela | O que mostra |
|---|---|
| Lançamentos | Todos os lançamentos (receita, despesa, transferência) |
| Contas a pagar / a receber | Despesas / receitas, filtradas por situação (pendentes por padrão). Mesmo controller (`ContasController`), o tipo vem da rota |
| Painel | Saldo atual, receitas e despesas pagas no mês, próximas contas pendentes |
| Extrato | Movimentações pagas no período (mês atual por padrão), em ordem cronológica, com saldo anterior e saldo acumulado |

Regras:

- **Saldo** = receitas pagas − despesas pagas, pela **data de pagamento**. Pendentes e cancelados não entram; transferências não alteram o saldo total.
- **Pagar / receber** marca o lançamento como `pago` com a data; desmarcar volta para `pendente`. **Cancelado** sai do saldo e não pode mais ser pago nem editado.
- **Pagamentos de associados** (mensalidade/anuidade) geram e mantêm sozinhos a receita correspondente (`origem = pagamento`): criar, editar ou excluir o pagamento atualiza o financeiro. Essa receita não é editada pelo financeiro, só pela tela de pagamentos.
- Um associado tem no máximo **um pagamento de cada tipo por mês de referência** (índice único).
- Valores aceitam o formato brasileiro (`1.234,56`) e o mês de referência aceita `mm/aaaa` ou `aaaa-mm` (`DinheiroHelper`, `MesReferenciaHelper`).

**Importação de CSV** (separador `;`): colunas `nome`, `cpf`, `matricula`, `valor`, `mes_referencia` (aceita variações como "Mês de Referência"). Pode ter uma linha de título antes do cabeçalho. Arquivos salvos pelo Excel em ANSI são convertidos para UTF-8, e o CPF que perdeu o zero à esquerda é corrigido. Linhas inválidas viram falhas no relatório, sem cancelar o lote.

## Armazenamento de arquivos

Todos os arquivos ficam no **SeaweedFS** (API S3), em dois buckets privados:

| Bucket (disco) | O quê | Acesso |
|---|---|---|
| `documentos` | Documentos dos associados (pastas de documentos) | Só admin/moderador, em `/associado/pasta/documentos/show/...` |
| `midia` | Fotos de perfil, imagens de posts, banners e benefícios | Público, em `/midia/img/...` e `/midia/picture_profiles/...` (`MidiaController`) |

O SeaweedFS roda no Easypanel **sem portas publicadas**. O navegador nunca fala com ele: o Laravel lê o arquivo pela rede interna (`AWS_ENDPOINT=http://<projeto>_seaweedfs-s3:8333`) e entrega. Por isso a URL de uma imagem vem de `$file->url` ou `$pictureProfile->url`, nunca de `asset('storage/...')`.

Para criar os buckets (uma vez), no console do serviço `seaweedfs-master`:

```bash
weed shell
> s3.bucket.create -name documentos
> s3.bucket.create -name midia
```

Registros de arquivos que não existem mais no armazenamento (por exemplo, depois de descartar arquivos antigos) são removidos com:

```bash
php artisan arquivos:limpar-orfaos --simular   # só lista
php artisan arquivos:limpar-orfaos             # apaga os registros
```

Backup: os arquivos ficam no volume `volume-data` e o índice no `filer-data` do SeaweedFS. Faça backup dos dois juntos.

## Acesso inicial

O seeder `RoleAndAdminSeeder` cria os perfis e um usuário administrador:

| E-mail | Senha |
|---|---|
| `admin@exemplo.com` | `senha123` |

> ⚠️ Troque essa senha imediatamente em qualquer ambiente que não seja de desenvolvimento.

## Variáveis de ambiente adicionais

Além das variáveis padrão do Laravel, o sistema usa:

| Variável | Uso |
|---|---|
| `INSTAGRAM_ACCESS_TOKEN` | Token da Graph API para exibir o feed do Instagram |
| `INSTAGRAM_USER_ID` | ID da conta do Instagram |
| `N8N_API_KEY` | Chave compartilhada com o n8n no header `x-api-key`, usada nas chamadas do Laravel para o n8n e do n8n para a API de automações |
| `AWS_ENDPOINT`, `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION` | Acesso ao SeaweedFS (API S3) |
| `AWS_BUCKET_DOCUMENTOS`, `AWS_BUCKET_MIDIA` | Nome dos buckets (padrão `documentos` e `midia`) |
| `MAIL_*` | Envio de e-mails (verificação, recuperação de senha) |

## Tarefas agendadas

**Automações de WhatsApp** são disparadas pelo **n8n**, que chama periodicamente o endpoint:

| Endpoint | Função |
|---|---|
| `GET/POST /api/automacoes/executar` | Verifica as automações ativas que estão no dia de execução e envia as mensagens |
| `GET/POST /api/automacoes/test` | Simula a execução e retorna, em JSON, quem receberia cada mensagem (não grava `ultima_execucao`) |

Os dois endpoints exigem o header `x-api-key` com o valor de `N8N_API_KEY`. Sem o token, ou com ele vazio no `.env`, a resposta é `401`.

**Tarefas do Laravel** (definidas em `routes/console.php`, confira com `php artisan schedule:list`):

| Comando | Frequência | Função |
|---|---|---|
| `app:clean-empty-folders` | diário | Remove pastas vazias do disco `public` |

Em produção, configure o cron do scheduler:

```cron
* * * * * cd /caminho/do/projeto && php artisan schedule:run >> /dev/null 2>&1
```

Em desenvolvimento, use `php artisan schedule:work`.

## Testes e qualidade

```bash
composer test          # roda a suíte PHPUnit
./vendor/bin/pint      # formata o código (Laravel Pint)
```

## Estrutura

```
app/
├── Console/Commands/   # Comandos artisan (automações, limpeza)
├── Helpers/            # CpfHelper, HierarchyHelper
├── Http/Controllers/   # Controllers (Financeiro/ e Diretoria/ em subpastas)
├── Livewire/           # Componentes Livewire (pesquisa, Instagram, usuários, notificações)
├── Models/
└── Services/
database/
├── migrations/
└── seeders/            # Perfis e usuário admin
resources/views/        # Views Blade organizadas por módulo
routes/
├── web.php
└── api.php
docker/                 # Nginx, PHP, Supervisor e entrypoint da imagem Docker
```

## Contribuição

1. Crie uma branch a partir da `main`: `git checkout -b feat/minha-alteracao`
2. Faça commits seguindo o padrão já usado no projeto (`feat:`, `fix:`, `refactor:`…)
3. Rode os testes e o Pint antes de abrir o Pull Request
