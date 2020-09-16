<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class tta extends Mailable
{
    use Queueable, SerializesModels;

    public $mail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        //
        $this->mail = $info;
    }
     
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->view('mail',[
            'html'=>$this->mail->getHTMLBody()
            ])
        ->subject($this->mail->getSubject());

    }
}
