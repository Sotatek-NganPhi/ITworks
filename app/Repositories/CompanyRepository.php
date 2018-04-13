<?php

namespace App\Repositories;

use App\Models\Company;
use InfyOm\Generator\Common\BaseRepository;

class CompanyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name' => 'like',
        'name_phonetic' => 'like',
        'street_address' => 'like',
        'contact_name' => 'like',
        'phone_number' => 'like',
        'short_description' => 'like',
        'company_hp',
        'expire_date',
        'is_active',
        'managers.manager_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Company::class;
    }
}
