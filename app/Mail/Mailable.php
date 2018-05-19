<?php

namespace App\Mail;

use View;
use Carbon\Carbon;

use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Mail\Mailable as BaseMailable;

class Mailable extends BaseMailable
{
    protected $type;

    public function send(MailerContract $mailer)
    {
        parent::send($mailer);
        if (!count($mailer->failures())) {
            $this->saveMailLog();
        };
    }

    // public function saveMailLog()
    // {
    //     $content = View::make($this->view, $this->viewData)->render();
    //     MailLogs::insert([
    //         'sender' => "{$this->from[0]['name']} <{$this->from[0]['address']}>",
    //         'recipient' => "{$this->to[0]['name']} <{$this->to[0]['address']}>",
    //         'subject' => $this->subject,
    //         'type' => $this->type,
    //         'content' => $content,
    //     ]);
    // }
}
