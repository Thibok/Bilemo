<?php

/**
 * Authenticate an user with Facebook
 */

namespace AppBundle\Authenticator;

use Doctrine\ORM\ORMException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Exception\ConnectionException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

/**
 * FacebookAuthenticator
 */
class FacebookAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @var SerializerInterface
     * @access private
     */
    private $serializer;

    /**
     * Constructor
     * @access public
     * @param SerializerInterface $serializer
     * 
     * @return void
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function createToken(Request $request, $providerKey)
    {
        if(!$bearer = $request->headers->get('Authorization')) {
            throw new CustomUserMessageAuthenticationException('You must be logged to access this resource !');
        }

        $accessToken = substr($bearer, 7);

        return new PreAuthenticatedToken(
            'anon.',
            $accessToken,
            $providerKey
        );
    }

    /**
     * @inheritDoc
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @inheritDoc
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $accessToken = $token->getCredentials();

        try {
            $userResult = $userProvider->loadUserByAccessToken($accessToken);
        } catch(\Exception $e) {
            if ($e instanceof ConnectionException || $e instanceof ORMException) {
                $userResult = 'An error is occured with the server';
            }
        }

        if (is_string($userResult)) {
            throw new CustomUserMessageAuthenticationException($userResult);
        }

        return new PreAuthenticatedToken(
            $userResult,
            $accessToken,
            $providerKey,
            $userResult->getRoles()
        );
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
       $error = 'Authentication error: ' .$exception->getMessage();

       $body = [
           'code' => 401,
           'message' => $error
       ];

       $body = $this->serializer->serialize($body, 'json');

       return new Response($body, 401);
    }
}