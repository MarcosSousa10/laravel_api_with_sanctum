<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

/**
 * Class VerificationEmail
 *
 * Esta classe representa um e-mail de verificação enviado ao usuário.
 */
class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Cria uma nova instância da classe VerificationEmail.
     *
     * @param User $user O usuário que receberá o e-mail de verificação.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Define o conteúdo do e-mail.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verification')
            ->subject('Verifique seu endereço de e-mail')
            ->with([
                'verificationUrl' => url("api/verify-email/{$this->user->email_verification_token}"),
            ]);
    }
}
