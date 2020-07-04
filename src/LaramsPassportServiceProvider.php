<?php

namespace Larams\Cms;

use App\Grant\ClientEmailGrant;
use App\Grant\FacebookGrant;
use App\Grant\GoogleGrant;
use App\Grant\ImpersonateGrant;
use App\Repository\Users;
use Laravel\Passport\Bridge\PersonalAccessGrant;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;

class PassportServiceProvider extends \Laravel\Passport\PassportServiceProvider
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

    protected function makeGoogleGrant()
    {
        $grant = new GoogleGrant(
            $this->app->make(Users::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }

    protected function makeCLientEmailGrant()
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
                    $this->makeGoogleGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makeImpersonateGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makeCLientEmailGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makePasswordGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    new PersonalAccessGrant(), new \DateInterval('P1Y')
                );

                $server->enableGrantType(
                    new ClientCredentialsGrant(), Passport::tokensExpireIn()
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
