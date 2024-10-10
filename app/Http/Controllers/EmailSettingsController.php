<?php

// app/Http/Controllers/EmailSettingsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class EmailSettingsController extends Controller
{
    public function update(Request $request)
    {
        // Validação das entradas
        $request->validate([
            'MAIL_MAILER' => 'required|string',
            'MAIL_HOST' => 'required|string',
            'MAIL_PORT' => 'required|integer',
            'MAIL_USERNAME' => 'required|string|email',
            'MAIL_PASSWORD' => 'required|string',
            'MAIL_ENCRYPTION' => 'required|string',
            'MAIL_FROM_ADDRESS' => 'required|string|email',
            'MAIL_FROM_NAME' => 'required|string',
        ]);

        // Carregando o arquivo .env
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        // Atualizando as configurações
        $newContent = preg_replace('/^MAIL_MAILER=.*/m', 'MAIL_MAILER=' . $request->MAIL_MAILER, $envContent);
        $newContent = preg_replace('/^MAIL_HOST=.*/m', 'MAIL_HOST=' . $request->MAIL_HOST, $newContent);
        $newContent = preg_replace('/^MAIL_PORT=.*/m', 'MAIL_PORT=' . $request->MAIL_PORT, $newContent);
        $newContent = preg_replace('/^MAIL_USERNAME=.*/m', 'MAIL_USERNAME=' . $request->MAIL_USERNAME, $newContent);
        $newContent = preg_replace('/^MAIL_PASSWORD=.*/m', 'MAIL_PASSWORD=' . $request->MAIL_PASSWORD, $newContent);
        $newContent = preg_replace('/^MAIL_ENCRYPTION=.*/m', 'MAIL_ENCRYPTION=' . $request->MAIL_ENCRYPTION, $newContent);
        $newContent = preg_replace('/^MAIL_FROM_ADDRESS=.*/m', 'MAIL_FROM_ADDRESS=' . $request->MAIL_FROM_ADDRESS, $newContent);
        $newContent = preg_replace('/^MAIL_FROM_NAME=.*/m', 'MAIL_FROM_NAME="' . $request->MAIL_FROM_NAME . '"', $newContent);

        // Salvando as novas configurações no arquivo .env
        File::put($envPath, $newContent);

        // Recarregar as configurações
        Config::set('mail.mailers.smtp', [
            'transport' => $request->MAIL_MAILER,
            'host' => $request->MAIL_HOST,
            'port' => $request->MAIL_PORT,
            'username' => $request->MAIL_USERNAME,
            'password' => $request->MAIL_PASSWORD,
            'encryption' => $request->MAIL_ENCRYPTION,
        ]);

        return response()->json(['message' => 'Configurações de e-mail atualizadas com sucesso.']);
    }
}
