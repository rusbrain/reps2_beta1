<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateOldUserPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    private $token;

    /**
     * Create a new message instance.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(config('mail.from.email'), config('mail.from.name'))
            ->subject('Обновите Ваш пароль на Reps.ru')
            ->view('emails.auth.update_old_password')
            ->with('token',$this->token);
    }
}
