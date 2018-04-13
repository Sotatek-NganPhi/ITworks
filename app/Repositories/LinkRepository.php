<?php

namespace App\Repositories;

use App\Models\Link;
use InfyOm\Generator\Common\BaseRepository;

class LinkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'area_name',
        'link_title' => 'like',
        'url',
        'url_pc',
        'order_by',
        'url_mobile',
        'image',
        'image_pc',
        'image_mobile',
        'start_date' => '>=',
        'end_date' => '<=',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Link::class;
    }

    public function rules()
    {
        return Link::$rules;
    }
}
