<?php

namespace Larams\Cms;

use Larams\Cms\Grant\AppleGrant;
use Larams\Cms\Grant\ClientCredentialsUserGrant;
use Larams\Cms\Grant\ClientEmailGrant;
use Larams\Cms\Grant\FacebookGrant;
use Larams\Cms\Grant\GoogleGrant;
use Larams\Cms\Grant\ImpersonateGrant;
use Larams\Cms\Repository\Users;
use Laravel\Passport\Bridge\PersonalAccessGrant;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;

class LaramsPassportServiceProvider extends \Laravel\Passport\PassportServiceProvider
{
    protected function makeFacebookGrant()
    {
        $grant = new FacebookGrant(
            $this->app->make(Users::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }

    protected function makeAppleGrant()
    {
        $grant = new AppleGrant(
            $this->app->make(Users::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }

    protected function makeGoogleGrant()
    {
        $grant = new GoogleGrant(
            $this->app->make(Users::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }

    protected function makeClientEmailGrant()
    {
        $grant = new ClientEmailGrant(
            $this->app->make(Users::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }

    protected function makeImpersonateGrant()
    {
        $grant = new ImpersonateGrant(
            $this->app->make(Users::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }

    /**
     * Register the authorization server.
     *
     * @return void
     */
    protected function registerAuthorizationServer()
    {
        $this->app->singleton(AuthorizationServer::class, function () {
            return tap($this->makeAuthorizationServer(), function ($server) {
                $server->enableGrantType(
                    $this->makeAuthCodeGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makeRefreshTokenGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makeFacebookGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makeAppleGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makeGoogleGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makeImpersonateGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makeClientEmailGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makePasswordGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    new PersonalAccessGrant(), new \DateInterval('P1Y')
                );

                $server->enableGrantType(
                    new ClientCredentialsUserGrant(), Passport::tokensExpireIn()
                );

                if (Passport::$implicitGrantEnabled) {
                    $server->enableGrantType(
                        $this->makeImplicitGrant(), Passport::tokensExpireIn()
                    );
                }
            });
        });
    }

}
