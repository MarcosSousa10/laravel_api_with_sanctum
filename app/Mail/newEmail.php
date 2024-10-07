<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $messageContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $messageContent)
    {
        $this->name = $name;
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.new_Email') // Nome da view
                    ->subject('Assunto do E-mail') // Assunto do e-mail
                    ->with([
                        'name' => $this->name,
                        'messageContent' => $this->messageContent
                    ]);
    }
}
