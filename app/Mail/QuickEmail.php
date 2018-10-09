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
    private $subject;

    /**
     * Create a new message instance.
     *
     * @param $content
     * @param $subject
     */
    public function __construct($content, $subject)
    {
        $this->content = $content;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.base')
            ->subject($this->subject)
            ->from(env('MAIL_FROM_EMAIL'), env('MAIL_FROM_NAME'))
            ->with('content',$this->content);
    }
}
