<?php

namespace App;

use App\Models\Company;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    use Notifiable;

    const TYPE_SYS_ADMIN        = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'is_active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'username' => 'string',
        'name' => 'string',
        'email' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'is_active' => 'integer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'username' => 'string',
        'name' => '',
        'email' => 'email',
        'password' => 'sometimes|confirmed',
        'first_name' => '',
        'last_name' => '',
        'is_active' => 'boolean',
    ];

    public function isSysAdmin()
    {
        return $this->type == Consts::TYPE_SYS_ADMIN;
    }

    public function isManager()
    {
        return $this->isSysAdmin();
    }
}
