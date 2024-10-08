<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEmail;  // Certifique-se que você criou o mailable
use App\Models\EmailLog; // Opcional, se você estiver rastreando os envios no banco de dados

class EmailController extends Controller
{
    /**
     * Envia um e-mail baseado nos dados recebidos.
     */
    public function enviarEmail(Request $request)
    {
        // Validar os dados recebidos do front-end
        $request->validate([
            'name' => 'required|string|max:255',
            'messageContent' => 'required|string',
            'email' => 'required|email',
        ]);

        // Receber os dados da requisição
        $name = $request->input('name');
        $messageContent = $request->input('messageContent');
        $email = $request->input('email');

        // Enviar o e-mail usando o Mailable 'NewEmail'
        Mail::to($email)->send(new NewEmail($name, $messageContent));

        // Salvar no banco de dados se necessário (opcional)
        // EmailLog::create([
        //     'name' => $name,
        //     'messageContent' => $messageContent,
        //     'email' => $email,
        // ]);

        return response()->json(['message' => 'E-mail enviado com sucesso!'], 200);
    }
}
