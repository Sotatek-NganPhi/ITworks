<?php

namespace App\Socialite;

use Laravel\Socialite\Two\User;

class GoogleProvider extends \Laravel\Socialite\Two\GoogleProvider
{
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id'         => $user['id'],
            'nickname'   => null, 
            'name'       => $user['displayName'],
            'email'      => $user['emails'][0]['value'],
            'first_name' => isset($user['name']) ? $user['name']['givenName'] : null,
            'last_name'  => isset($user['name']) ? $user['name']['familyName'] : null,
            'gender'     => isset($user['gender']) ? $user['gender'] : null,
            'birthday'   => isset($user['birthday']) ? $user['birthday'] : null,
        ]);
    }
}
