<?php

namespace App;

use App\Models\Draft;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'address',
        'phone_number',
        'gender',
        'birthday',
        'confirmed',
        'confirmation_code',
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
        'first_name'          => 'required|string|max:255',
        'last_name'           => 'required|string|max:255',
        'gender'              => 'required|in:male,female',
        'address'             => 'required|string|max:255',
        'phone_number'        => 'required',
        'birthday'            => 'required|date_format:Y-m-d',
        'email'               => 'string|email|max:255',
        'password'            => 'string|min:6|confirmed',
    ];

    public function getBirthdayAttribute($value)
    {
        return $value ? date('Y-m-d', strtotime($value)) : $value;
    }

    public function socialProviders()
    {
        return $this->hasMany('App\Models\SocialProvider');
    }

    public function candidate()
    {
        return $this->hasOne('App\Models\Candidate');
    }
    
    public function scopeGetBySocialProvider($query, $provider, $provider_id)
    {
        return $query->whereHas('socialProviders', function ($query) use ($provider, $provider_id) {
            $query->where('provider', $provider)->where('provider_id', $provider_id);
        });
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, $this->toArray()));
    }

    public function draft()
    {
         return $this->hasOne(Draft::class);
    }
}