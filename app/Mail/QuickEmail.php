<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuickEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $content;
    public $subject;
    public $mail_to;

    /**
     * Create a new message instance.
     *
     * @param $content
     * @param $subject
     * @param $mail_to
     */
    public function __construct($content, $subject, $mail_to)
    {
        $this->content = $content;
        $this->subject = $subject;
        $this->mail_to = $mail_to;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.base')
            ->subject($this->subject)
            ->to($this->mail_to)
            ->from(env('MAIL_FROM_EMAIL', 'info@reps.ru'), env('MAIL_FROM_NAME', 'REPS.RU'))
            ->with('content',$this->content);
    }
}
