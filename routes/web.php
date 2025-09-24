<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\CondPagamentoController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ParController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\InvestController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/cadastro', function () {
    return view('cadastroUsuario');
})->name('cadastro');

Route::get('/recuperarSenha', function (){
    return view ('recuperarSenha');
})->name('recuperarSenha');

/* Rotas privadas */
Route::middleware(['verifica.login'])->group(function () {

    /* Dashboard */
    Route::get('/dashboard', [DashController::class, 'receitaXdespesa'])->name('dashboard');

    /* Extrato */
    Route::get('/extrato', [MovController::class, 'exibir'])->name('extrato');
    Route::get('/extratoExportExcel', [ExportExcelController::class, 'export'])->name('export');
    Route::post('/extratoImportExcel', [ExportExcelController::class, 'import'])->name('export');
    Route::post('/extrato', [MovController::class, 'store'])->name('cadastroMov');
    Route::get('/extrato/{movb_codigo}/edit', [MovController::class, 'edit'])->name('editMov');
    Route::put('/extrato/{movb_codigo}', [MovController::class, 'update'])->name('updateMov');
    Route::delete('/extrato/{movb_codigo}', [MovController::class, 'destroy'])->name('deleteMov');
    
    Route::get('/parcelamento/{movb_codigo}', [MovController::class, 'parcelamento'])->name('parcelamento');
    Route::put('/parcelamento/{movb_codigo}/{movb_codigomov}', [ParController::class, 'update'])->name('updatePar');

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

/* Rotas públicas */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/cadastro', [AuthController::class, 'cadastro'])->name('cadastro');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


