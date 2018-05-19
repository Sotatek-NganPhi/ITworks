<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lang;

class ApplicationToCandidate extends Mailable
{
    use Queueable, SerializesModels;
    protected $params;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.application')
            ->subject(Lang::get('email.application.subject'))
            ->with([
                'applicant' => $this->params,
            ]);
    }
}
