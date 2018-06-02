<?php

namespace App\Mail;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class ApplicationToEmployer extends Mailable
{
    use Queueable, SerializesModels;
    protected $job;
    protected $applicant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Job $job, Applicant $applicant)
    {
        $this->job = $job;
        $this->applicant = $applicant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        logger($this->job);
        logger($this->applicant);
        return $this->view('emails.application_to_employer')
            ->with([
                'job' => $this->job,
                'applicant' => $this->applicant,
            ]);
    }
}
