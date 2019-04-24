<?php

namespace App\Mail;

use App\UserEmailToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisteredUser extends Mailable
{
    use Queueable, SerializesModels;

    private $token;
    private $user;

    /**
     * Create a new message instance.
     *
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
        $token = md5(time());

        UserEmailToken::create(
            [
                'user_id' => $user->id,
                'function' => UserEmailToken::TOK_FUNC_VERIFIED_EMAIL,
                'token' => $token
            ]
        );

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->from(config('mail.from.email'), config('mail.from.name'))
            ->subject('Вы зарегестрировались на reps.ru')
            ->markdown('emails.registered')
            ->with('token',$this->token);
    }
}
