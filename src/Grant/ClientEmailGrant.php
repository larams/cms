<?php
/**
 * OAuth 2.0 Password grant.
 *
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\Grant;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\RequestEvent;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Password grant class.
 */
class ClientEmailGrant extends PasswordGrant
{
    /**
     * @param ServerRequestInterface $request
     * @param ClientEntityInterface $client
     *
     * @throws OAuthServerException
     *
     * @return UserEntityInterface
     */
    protected function validateUser(ServerRequestInterface $request, ClientEntityInterface $client)
    {
        $email = $this->getRequestParameter('email', $request);
        if (is_null($email)) {
            throw OAuthServerException::invalidRequest('email');
        }

        $userId = $this->getRequestParameter('user_id', $request);
        if (is_null($userId)) {
            throw OAuthServerException::invalidRequest('user_id');
        }

        $user = $this->userRepository->getUserEntityByUserCredentials(
            $email,
            $userId,
            $this->getIdentifier(),
            $client
        );
        if ($user instanceof UserEntityInterface === false) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::USER_AUTHENTICATION_FAILED, $request));

            throw OAuthServerException::invalidCredentials();
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return 'client_email';
    }
}
