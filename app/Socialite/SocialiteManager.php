<?php

namespace App\Socialite;

class SocialiteManager extends \Laravel\Socialite\SocialiteManager
{
    protected function createYahooJpDriver()
    {
        $config = $this->app['config']['services.yahoojp'];

        return $this->buildProvider(YahooJpProvider::class, $config);
    }

    protected function createFacebookDriver()
    {
        $config = $this->app['config']['services.facebook'];

        return $this->buildProvider(FacebookProvider::class, $config);
    }

    protected function createGoogleDriver()
    {
        $config = $this->app['config']['services.google'];

        return $this->buildProvider(GoogleProvider::class, $config);
    }
}
