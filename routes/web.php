<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\CondPagamentoController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ParController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\InvestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AssinaturaController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/cadastro', function () {
    return view('cadastroUsuario');
})->name('cadastro');

Route::get('/recuperarSenha', function (){
    return view ('recuperarSenha');
})->name('recuperarSenha');

Route::middleware(['web'])->group(function () {  
    Route::get("/", [HomeController::class,"index"])->name("home");  
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/cadastro', [AuthController::class, 'cadastro'])->name('cadastro');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    /* Rotas de exigir login para assinar */
    Route::middleware(['verifica.login'])->group(function () {
        // Página para o usuário escolher o plano
        Route::get('/assinar', [AssinaturaController::class, 'index'])->name('assinar');

        // POST para confirmar assinatura
        Route::post('/assinar', [AssinaturaController::class, 'assinar'])->name('assinar.post');

    });

    // Rotas privadas (precisam de login + assinatura ativa)
    Route::middleware(['verifica.login'])->group(function () {
        /* Dashboard */
        Route::get('/dashboard', [DashController::class, 'receitaXdespesa'])->name('dashboard');

        /* Extrato */
        Route::get('/extrato', [MovController::class, 'exibir'])->name('extrato');
        Route::get('/extratoExportExcel', [ExportExcelController::class, 'export'])->name('export');
        Route::post('/extrato', [MovController::class, 'store'])->name('cadastroMov');
        Route::get('/extrato/{movb_codigo}/edit', [MovController::class, 'edit'])->name('editMov');
        Route::put('/extrato/{movb_codigo}', [MovController::class, 'update'])->name('updateMov');
        Route::delete('/extrato/{movb_codigo}', [MovController::class, 'destroy'])->name('deleteMov');
        
        Route::get('/parcelamento/{movb_codigo}', [MovController::class, 'parcelamento'])->name('parcelamento');
        Route::put('/parcelamento/{movb_codigo}/{movb_codigomov}', [ParController::class, 'update'])->name('updatePar');

        /* Pessoa */
        Route::get('/pessoa', [PessoaController::class, 'exibir'])->name('pessoa');    
        Route::post('/pessoa', [PessoaController::class, 'store'])->name('pessoa.store');
        Route::put('/pessoa/{pes_codigo}', [PessoaController::class,'update'])->name('updatePes');
        Route::delete('/pessoa/{pes_codigo}', [PessoaController::class, 'destroy'])->name('deletePes');

        /* Buscar Pessoa */
        Route::get('/pessoa/buscar ', [PessoaController::class,'buscar']);
        Route::get('/extrato/{movb_pessoa}/buscar ', [PessoaController::class,'buscarUpdate']);

        /* Categorias */
        Route::get('/categorias', [CatController::class, 'exibir'])->name('categorias');
        Route::post('/categorias', [CatController::class, 'store'])->name('categorias.store');
        Route::put('/categorias/{copa_codigo}', [CatController::class, 'update'])->name('updateCondP');
        Route::delete('/categorias/{copa_codigo}', [CatController::class, 'destroy'])->name('deleteCondP');

        /* Condições de Pagamento */
        Route::get('/condicoesPagamento', [CondPagamentoController::class, 'exibir'])->name('condicoesPagamento');
        Route::post('/condicoesPagamento', [CondPagamentoController::class, 'store'])->name('CondPagamento.store');
        Route::put('/condicoesPagamento/{copa_codigo}', [CondPagamentoController::class, 'update'])->name('updateCondP');
        Route::delete('/condicoesPagamento/{copa_codigo}', [CondPagamentoController::class, 'destroy'])->name('deleteCondP');

        /* Usuário */
        Route::get('/usuario', [AuthController::class, 'usuario']);
        Route::get('/usuario/alterar-senha', [AuthController::class, 'editSenha'])->name('usuario.editSenha');
        Route::put('/usuario/alterar-senha', [AuthController::class, 'updateSenha'])->name('usuario.updateSenha');
        Route::put('/usuario/editar-usuario', [AuthController::class, 'editUser'])->name('usuario.edit');

        /* Investimento */
        Route::get('/investimento', [InvestController::class, 'exibir'])->name('investimento');
    });
});

