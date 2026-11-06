<?php

namespace Tests\Feature;

use App\Http\Controllers\MidiaController;
use App\Models\Associado;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route as Rota;
use Illuminate\Routing\ViewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

// Rede de proteção das rotas: toda rota do projeto precisa de login e de um perfil,
// a não ser que esteja numa das listas abaixo. Rota nova sem proteção faz este teste falhar.
class RotasProtegidasTest extends TestCase
{
    use RefreshDatabase;

    // Abertas a visitantes (routes/web/publico.php)
    private const PUBLICAS = [
        'GET /',
        'GET search',
        'GET contatos',
        'GET Quem_Somos',
        'GET perguntasfrequentes/index',
        'GET api/instagram/media',
        'GET posts/{post}',
        'GET beneficio',
        'GET register',
        'GET associado/create',
        'POST associado/store',
        'GET api/cidades/{uf}',
        'GET carteira-associado-verificacao/{id}',
    ];

    // Só login, qualquer perfil (routes/web/associado.php)
    private const SO_LOGIN = [
        'GET trocar-senha',
        'POST trocar-senha',
        'GET dashboard',
        'GET profile',
        'GET associado/financeiro',
        'GET asssociado/informacoes/{id}',
        'POST associado/{associadoId}/picture-profile/store',
        'DELETE associado/{associadoId}/picture-profile/destroy',
        'GET carteira-associados/{id}',
        'GET carteira-associados1/{id}',
    ];

    /** Rotas definidas pelo projeto (ignora as do Jetstream, Fortify, Livewire etc.) */
    private function rotasDoProjeto(): array
    {
        $rotas = [];

        foreach (Route::getRoutes() as $rota) {
            $controller = ltrim((string) $rota->getControllerClass(), '\\');

            $doProjeto = $controller === ViewController::class
                || (Str::startsWith((string) $controller, 'App\\Http\\Controllers\\') && $controller !== MidiaController::class);

            if ($doProjeto && in_array('web', $rota->gatherMiddleware())) {
                $rotas[$this->chave($rota)] = $rota;
            }
        }

        return $rotas;
    }

    private function chave(Rota $rota): string
    {
        $metodo = collect($rota->methods())->reject(fn ($m) => $m === 'HEAD')->first();

        return "{$metodo} {$rota->uri()}";
    }

    public function test_toda_rota_exige_login_e_perfil_fora_das_listas_de_excecao(): void
    {
        $semProtecao = [];

        foreach ($this->rotasDoProjeto() as $chave => $rota) {
            if (in_array($chave, self::PUBLICAS)) {
                continue;
            }

            $middlewares = $rota->gatherMiddleware();
            $temLogin = in_array('auth', $middlewares);
            $temPerfil = collect($middlewares)->contains(fn ($m) => Str::startsWith($m, 'role:'));

            if (! $temLogin || (! $temPerfil && ! in_array($chave, self::SO_LOGIN))) {
                $semProtecao[] = $chave;
            }
        }

        $this->assertSame([], $semProtecao, 'Rotas sem proteção: coloque-as no arquivo certo de routes/web/');
    }

    public function test_listas_de_excecao_nao_tem_rotas_que_nao_existem(): void
    {
        $existentes = array_keys($this->rotasDoProjeto());

        $this->assertSame([], array_values(array_diff(self::PUBLICAS, $existentes)));
        $this->assertSame([], array_values(array_diff(self::SO_LOGIN, $existentes)));
    }

    public static function rotasDoPainel(): array
    {
        return [
            'associados' => ['/associado'],
            'documento para impressão' => ['/pdf.requerimento/1'],
            'pagamentos' => ['/pagamentos/index'],
            'configurações' => ['/configuracoes'],
            'usuários (só admin)' => ['/usuarios'],
            'financeiro' => ['/financeiro'],
            'diretoria' => ['/diretoria'],
        ];
    }

    #[DataProvider('rotasDoPainel')]
    public function test_visitante_vai_para_o_login(string $url): void
    {
        $this->get($url)->assertRedirect(route('login'));
    }

    #[DataProvider('rotasDoPainel')]
    public function test_associado_volta_para_o_site_com_aviso(string $url): void
    {
        $this->seed(RoleSeeder::class);
        $associado = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => '11111111111']);
        $usuario = User::factory()->create(['associado_id' => $associado->id]);
        $usuario->assignRole('associado');

        $this->actingAs($usuario)->get($url)
            ->assertRedirect(route('index'))
            ->assertSessionHas('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
    }

    public function test_moderador_nao_entra_nas_areas_so_de_admin(): void
    {
        $this->seed(RoleSeeder::class);
        $moderador = User::factory()->create();
        $moderador->assignRole('moderador');

        $this->actingAs($moderador)->get('/usuarios')->assertRedirect(route('index'));
        $this->actingAs($moderador)->get('/diretoria')->assertRedirect(route('index'));
        $this->actingAs($moderador)->get('/financeiro')->assertRedirect(route('index'));
        $this->actingAs($moderador)->get('/configuracoes')->assertOk();
    }

    private function usuarioComPerfis(string ...$perfis): User
    {
        $this->seed(RoleSeeder::class);
        $associado = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => '11111111111']);
        $usuario = User::factory()->create(['associado_id' => $associado->id]);
        $usuario->assignRole($perfis);

        return $usuario;
    }

    public static function telasDoFinanceiro(): array
    {
        return [
            'gestão financeira' => ['/financeiro'],
            'pagamentos' => ['/pagamentos/index'],
            'importar pagamentos' => ['/importar-pagamentos'],
            'planos' => ['/planos/index'],
        ];
    }

    #[DataProvider('telasDoFinanceiro')]
    public function test_financeiro_entra_nas_telas_financeiras(string $url): void
    {
        $this->actingAs($this->usuarioComPerfis('financeiro'))->get($url)->assertOk();
    }

    #[DataProvider('telasDoFinanceiro')]
    public function test_moderador_nao_entra_nas_telas_financeiras(string $url): void
    {
        $this->actingAs($this->usuarioComPerfis('moderador'))->get($url)->assertRedirect(route('index'));
    }

    public function test_financeiro_nao_entra_no_administrativo(): void
    {
        $financeiro = $this->usuarioComPerfis('financeiro');

        foreach (['/associado', '/configuracoes', '/usuarios', '/diretoria'] as $url) {
            $this->actingAs($financeiro)->get($url)->assertRedirect(route('index'));
        }
    }

    public function test_login_do_financeiro_vai_para_o_financeiro(): void
    {
        // Financeiro vem antes de associado na prioridade da tela inicial
        $this->actingAs($this->usuarioComPerfis('financeiro', 'associado'))
            ->get('/dashboard')
            ->assertRedirect(route('financeiro.index'));
    }

    public function test_financeiro_que_e_associado_ve_os_proprios_dados_no_menu(): void
    {
        $usuario = $this->usuarioComPerfis('financeiro', 'associado');

        $this->actingAs($usuario)->get('/financeiro')
            ->assertOk()
            ->assertSee('Meus Dados')
            ->assertSee(route('associado.informacoes', $usuario->associado_id))
            ->assertDontSee('href="' . route('associado.index') . '"', false);
    }

    public function test_pedido_json_sem_perfil_recebe_403(): void
    {
        $this->seed(RoleSeeder::class);
        $usuario = User::factory()->create();
        $usuario->assignRole('user');

        $this->actingAs($usuario)->getJson('/associado')->assertForbidden();
    }
}
