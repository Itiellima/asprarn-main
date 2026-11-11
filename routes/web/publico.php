<?php

use App\Http\Controllers\Associado\CadastroController;
use App\Http\Controllers\Associado\CarteirinhaController;
use App\Http\Controllers\BeneficioController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\PerguntasFrequentesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\searchPostController;
use Illuminate\Support\Facades\Route;

// Rotas abertas a visitantes. Antes de colocar uma rota aqui, inclua o nome dela
// na lista de públicas do tests/Feature/RotasProtegidasTest.php.

//////////////////////////////// ********* SITE ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/search', [searchPostController::class, 'index'])->name('search');
Route::view('/contatos', 'contato.index')->name('contato.index');
Route::view('/Quem_Somos', 'quem-somos.index')->name('quem.somos');
Route::get('/perguntasfrequentes/index', [PerguntasFrequentesController::class, 'index'])->name('perguntasfrequentes.index');
Route::get('/api/instagram/media', [InstagramController::class, 'getMedia']);

// Só números: "posts/create" fica no admin.php e não pode cair aqui
Route::get('posts/{post}', [PostController::class, 'show'])->whereNumber('post')->name('posts.show');
Route::get('beneficio', [BeneficioController::class, 'index'])->name('beneficio.index');

//////////////////////////////// ********* CADASTRO ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// O próprio associado se cadastra pelo site; o store também é usado pelo admin
Route::get('/register', [CadastroController::class, 'create'])->name('register.view');
Route::get('/associado/create', [CadastroController::class, 'create'])->name('associado.create');
Route::post('/associado/store', [CadastroController::class, 'store'])->name('associado.store');
Route::get('/api/cidades/{uf}', [CadastroController::class, 'cidades']);

//////////////////////////////// ********* VERIFICAÇÃO DA CARTEIRINHA ********* \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// Endereço impresso no QR code das carteirinhas: nunca mudar
Route::get('/carteira-associado-verificacao/{id}', [CarteirinhaController::class, 'validar'])->name('validar-carteirinha');
