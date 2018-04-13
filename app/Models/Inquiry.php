<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    public $fillable = [
        'company_name',
        'contact_person_signature',
        'name_person',
        'job_category',
        'postal_code',
        'address',
        'contact_phone_number',
        'contact_fax_number',
        'contact_email_address',
        'content_inquiry',
        'offering_content',
        'other',
        'desire'
    ];

}
