<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Code;

class ShareCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    /**
     * Create a new message instance.
     *
     * @param  Code  $code
     * @return void
     */
    public function __construct(Code $code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Envio de Código - Hotel de Leiria')
            ->view('emails.share_code')
            ->with([
            'code' => $this->code,
            ]);
    }
}
