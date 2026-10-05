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
| PDFs | barryvdh/laravel-dompdf |
| Frontend | Blade, Vite 7, Tailwind CSS, Bootstrap Icons, TinyMCE |
| Banco de dados | MySQL 8 |
| Armazenamento | Disco local/public (suporte a S3 disponível) |
| PWA | ladumor/laravel-pwa |
| Infra | Docker (PHP-FPM + Nginx + MySQL) |

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

```bash
docker compose up -d --build
```

Acesse http://localhost:8080. O `entrypoint.sh` aguarda o MySQL, cria o `.env` se não existir, gera a `APP_KEY` e roda as migrações e seeds automaticamente.

| Serviço | Container | Porta |
|---|---|---|
| Laravel (PHP-FPM) | `laravel_app` | 9000 (interna) |
| Nginx | `laravel_nginx` | 8080 |
| MySQL | `laravel_db` | 3306 |

Comandos úteis:

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan tinker
docker compose logs -f app
```

## Deploy em produção (Easypanel)

Produção roda como **App** no Easypanel, com build **Nixpacks** a partir deste repositório. Cada commit na `main` gera um novo build.

- O `Dockerfile`, o `docker-compose.yml` e o `nginx/default.conf` **não são usados em produção**, só no ambiente Docker local.
- O `.env` é configurado no Easypanel, fora do build, e se mantém entre os deploys.
- Ao recriar o container, rodam automaticamente:
  ```bash
  php artisan config:clear && php artisan key:generate && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=80
  ```
- As migrações **não** rodam sozinhas. Depois de um deploy com migração nova, rode `php artisan migrate --force` no console do serviço.
- Limite de upload: vale o php.ini padrão do Nixpacks (2 MB por arquivo). As fotos de perfil são reduzidas no navegador antes do envio (`public/js/redimensionar-foto.js`), então ficam bem abaixo disso.

## Armazenamento de arquivos

| O quê | Onde | Acesso |
|---|---|---|
| Documentos dos associados (pastas de documentos) | Disco `documentos`: bucket privado no **SeaweedFS** (API S3) | Só pelo Laravel, para admin/moderador (`/associado/pasta/documentos/show/...`) |
| Fotos de perfil, imagens de posts, banners, benefícios | Disco `public` (`storage/app/public`, volume do Easypanel) | Público, via `/storage/...` |

O SeaweedFS roda no Easypanel **sem portas publicadas**: o Laravel o acessa pela rede interna (`DOCUMENTOS_ENDPOINT=http://<projeto>_seaweedfs-s3:8333`) e entrega o arquivo ao navegador depois de conferir a permissão. O bucket nunca fica exposto na internet.

Para criar o bucket (uma vez), no console do serviço `seaweedfs-master`:

```bash
weed shell
> s3.bucket.create -name documentos
```

Backup: os arquivos ficam no volume `volume-data` e o índice no `filer-data`. Faça backup dos dois juntos.

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
| `FILESYSTEM_DISK`, `AWS_*` | Armazenamento de arquivos em S3 (opcional) |
| `DOCUMENTOS_ENDPOINT`, `DOCUMENTOS_BUCKET`, `DOCUMENTOS_KEY`, `DOCUMENTOS_SECRET` | Bucket privado (SeaweedFS, API S3) dos documentos dos associados |
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
nginx/default.conf      # Configuração do Nginx usada no Docker
```

## Contribuição

1. Crie uma branch a partir da `main`: `git checkout -b feat/minha-alteracao`
2. Faça commits seguindo o padrão já usado no projeto (`feat:`, `fix:`, `refactor:`…)
3. Rode os testes e o Pint antes de abrir o Pull Request
