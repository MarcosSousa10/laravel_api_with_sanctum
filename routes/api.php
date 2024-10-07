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
use App\Http\Controllers\AvaliacaoDeServicoController;
use App\Http\Controllers\CampanhaDeMarketingController;
use App\Http\Controllers\CartaoPresenteController;

Route::get('/status', function () {
    return ApiResponse::success('API is running');
})->middleware('auth:sanctum');
//Route::apiResource('cliente', ClientController::class)->middleware('auth:sanctum');
Route::get('cliente', [ClientController::class, "index"])->middleware(['auth:sanctum']);
Route::post('cliente', [ClientController::class, "store"])->middleware('auth:sanctum');
Route::get('cliente/{client}', [ClientController::class, "show"])->middleware(['auth:sanctum', 'ability:clients:detail']);
Route::put('cliente/{client}', [ClientController::class, "update"])->middleware('auth:sanctum');
Route::delete('cliente/{client}', [ClientController::class, "delete"])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/send-email', [EmailController::class, 'sendEmail']);
Route::get('/new_user_confirmation/{token}', [AuthController::class, 'new_user_confirmation']);

Route::get('/enviar-email', function () {
    $name = 'Cliente Teste';
    $messageContent = 'Este é o conteúdo do e-mail de teste.';

    Mail::to('destinatario@exemplo.com')->send(new NewEmail($name, $messageContent));

    return 'E-mail enviado com sucesso!';
});

Route::get('/report', [ReportController::class, 'generateReport']);
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('filiais', FilialController::class);
Route::apiResource('profissionais', ProfissionalController::class);
Route::apiResource('servicos', ServicoController::class);
Route::apiResource('agendamentos', AgendamentoController::class);
Route::apiResource('agendas-de-contatos', AgendaDeContatoController::class);
Route::apiResource('avaliacoes-de-servicos', AvaliacaoDeServicoController::class);
Route::apiResource('campanhas-de-marketing', CampanhaDeMarketingController::class);
Route::apiResource('cartoes-presente', CartaoPresenteController::class);
