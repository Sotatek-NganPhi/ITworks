<?php

namespace App\Mail;

use Lang;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Mail\Mailable;
use App\Models\FieldSetting;

class AutoMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $params;
    protected $jobs;
    protected $type = 'automatic';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($params, $jobs)
    {
        $this->params = $params;
        $this->jobs = $jobs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.automail')
                    ->from($this->params['from_address_email'] , $this->params['from_address_work'])
                    ->subject($this->params['subject'])
                    ->with([
                        'header' => $this->params['header'],
                        'footer' => $this->params['footer'],
                        'properties' => $this->getProperties(),
                        'jobs' => $this->jobs,
                    ]);
    }

    public function getProperties()
    {
        $fieldSettings = FieldSetting::where('table_name', '=', 'jobs')
            ->whereIn('field_name', $this->params['items'])
            ->get();

        return $fieldSettings->mapWithKeys(function ($fieldSetting) {
            return [$fieldSetting['field_name'] => $fieldSetting['display_name']];
        })->all();
    }
}
