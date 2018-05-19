<?php

namespace App\Socialite;

use \Laravel\Socialite\Two\User;

class FacebookProvider extends \Laravel\Socialite\Two\FacebookProvider
{
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id'         => $user['id'],
            'nickname'   => null,
            'name'       => isset($user['name']) ? $user['name'] : null,
            'email'      => isset($user['email']) ? $user['email'] : null,
            'gender'     => isset($user['gender']) ? $user['gender'] : null,
            'first_name' => isset($user['first_name']) ? $user['first_name'] : null,
            'last_name'  => isset($user['last_name']) ? $user['last_name'] : null,
            'birthday'   => isset($user['birthday']) ? $user['birthday'] : null,
        ]);
    }
}