<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServicoController;
use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Mail\NewEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AgendaDeContatoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AvaliacaoDeServicoController;
use App\Http\Controllers\CampanhaDeMarketingController;
use App\Http\Controllers\CartaoPresenteController;
use App\Http\Controllers\ComissaoController;
use App\Http\Controllers\ComunicacaoClienteController;
use App\Http\Controllers\ConfiguracaoDoSistemaController;
use App\Http\Controllers\ContaAPagarController;
use App\Http\Controllers\DesempenhoDosFuncionariosController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LogDeAuditoriaController;
use App\Http\Controllers\PreferenciasDosClientesController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProgramaFidelidadeController;
use App\Http\Controllers\PromocoesAtivasController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TemplatesDeNotificacoesController;
use App\Http\Controllers\TransacoesController;
use App\Http\Controllers\TransacaoInventarioController;
use App\Http\Controllers\VendaItemController;
use App\Http\Controllers\VendasController;
use App\Http\Middleware\CheckIfProfessional;
use App\Http\Middleware\LogAuditoria;

Route::get('/status', function () {
    return ApiResponse::success('API is running');
})->middleware('auth:sanctum');
Route::get('/report', [ReportController::class, 'generateReport']);
Route::get('/reportTransacao', [ReportController::class, 'generateReport1']);

//Route::apiResource('cliente', ClientController::class)->middleware('auth:sanctum');
Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.request');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);
Route::get('cliente', [ClientController::class, "index"])->middleware('auth:sanctum', LogAuditoria::class);
Route::post('cliente', [ClientController::class, "store"])->middleware('auth:sanctum', LogAuditoria::class);
Route::get('cliente/{client}', [ClientController::class, "show"])->middleware('auth:sanctum', LogAuditoria::class);
Route::put('cliente/{client}', [ClientController::class, "update"])->middleware('auth:sanctum', LogAuditoria::class);
Route::delete('cliente/{client}', [ClientController::class, "delete"])->middleware('auth:sanctum', LogAuditoria::class);
Route::post('/login', [AuthController::class, 'login'])->middleware(LogAuditoria::class);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum', LogAuditoria::class);
Route::post('register', [AuthController::class, 'createUser'])->middleware(LogAuditoria::class);
Route::post('/send-email', [EmailController::class, 'sendEmail'])->middleware(['auth:sanctum', 'ability:clients:detail']);
Route::get('/new_user_confirmation/{token}', [AuthController::class, 'new_user_confirmation']);
Route::post('/enviar-email', [EmailController::class, 'enviarEmail'])->middleware('auth:sanctum', CheckIfProfessional::class, LogAuditoria::class);
Route::get('/clientes/email', [ClienteController::class, 'getByEmail'])->middleware('auth:sanctum', LogAuditoria::class);
Route::get('/agendamentos/por-email', [AgendamentoController::class, 'filtrarPorEmail'])->middleware('auth:sanctum', LogAuditoria::class);
Route::get('/agendamentos/agendados', [AgendamentoController::class, 'filtrarAgendados'])->middleware('auth:sanctum', LogAuditoria::class);
Route::apiResource('clientes', ClienteController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('filiais', FilialController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
//CheckIfClient::class
Route::middleware(['auth:sanctum', 'can:profissional'])->group(function () {
    Route::apiResource('profissionais', ProfissionalController::class);
});
Route::apiResource('servicos', ServicoController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
//Route::apiResource('agendamentos', AgendamentoController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::middleware(['auth:sanctum', LogAuditoria::class])->group(function () {
    Route::get('agendamentos', [AgendamentoController::class, 'index'])->name('agendamentos.index')->middleware('can:profissional');
    Route::post('agendamentos', [AgendamentoController::class, 'store'])->name('agendamentos.store');
    Route::get('agendamentos/{id}', [AgendamentoController::class, 'show'])->name('agendamentos.show');
    Route::put('agendamentos/{id}', [AgendamentoController::class, 'update'])->name('agendamentos.update');
    Route::delete('agendamentos/{id}', [AgendamentoController::class, 'destroy'])->name('agendamentos.destroy');
});
Route::apiResource('agendas-de-contatos', AgendaDeContatoController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('avaliacoes-de-servicos', AvaliacaoDeServicoController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('campanhas-de-marketing', CampanhaDeMarketingController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('cartoes-presente', CartaoPresenteController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('comissoes', ComissaoController::class)->middleware(['auth:sanctum', CheckIfProfessional::class, LogAuditoria::class]);
Route::apiResource('comunicacao-clientes', ComunicacaoClienteController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('configuracoes-do-sistema', ConfiguracaoDoSistemaController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('contas-a-pagar', ContaAPagarController::class)->middleware(['auth:sanctum', CheckIfProfessional::class, LogAuditoria::class]);
Route::apiResource('desempenho-dos-funcionarios', DesempenhoDosFuncionariosController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('fornecedores', FornecedorController::class)->middleware(['auth:sanctum', CheckIfProfessional::class, LogAuditoria::class]);
Route::apiResource('inventario', InventarioController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('logs-de-auditoria', LogDeAuditoriaController::class)->middleware(['auth:sanctum', CheckIfProfessional::class, LogAuditoria::class]);
Route::apiResource('preferencias-dos-clientes', PreferenciasDosClientesController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('produtos', ProdutoController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('programas-fidelidade', ProgramaFidelidadeController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('promocoes-ativas', PromocoesAtivasController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('templates-de-notificacoes', TemplatesDeNotificacoesController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('transacoes', TransacoesController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('transacao-inventario', TransacaoInventarioController::class)->only(['index', 'store', 'show', 'destroy'])->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('vendas', VendasController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::apiResource('venda_item', VendaItemController::class)->middleware(['auth:sanctum', LogAuditoria::class]);
Route::post('/users/{id}/assign-role', [RolePermissionController::class, 'assignRole']);
Route::post('/users/{id}/remove-role', [RolePermissionController::class, 'removeRole']);
Route::post('/users/{id}/assign-permission', [RolePermissionController::class, 'assignPermission']);
Route::post('/users/{id}/remove-permission', [RolePermissionController::class, 'removePermission']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('users/{userId}/permissions', [RolePermissionController::class, 'getUserPermissions'])
        ->name('users.permissions');
});
