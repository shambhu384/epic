<?php

namespace App\Security;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class OTPAuthenticator extends AbstractGuardAuthenticator
{
    private $parent;

    private $generator;

    public function __construct(AppCustomAuthenticator $parent, UrlGeneratorInterface $generator)
    {
        $this->parent = $parent;
        $this->generator = $generator;

    }

    public function supports(Request $request)
    {
        return true;
    }

    public function getUser($credentails, UserProviderInterface $userProvider)
    {
        return $this->parent->getUser($credentails, $userProvider);
    }

    public function start(Request $request, ?AuthenticationException $authException = null)
    {
        return $this->parent->start($request, $authException);
    }

    public function supportsRememberMe()
    {
        return $this->parent->supportsRememberMe();
    }

    public function getCredentials(Request $request)
    {
        if ($this->parent->supports($request)) {
            return $this->parent->getCredentials($request);
        }

        return [
            'code' => $request->request->get('_top_code'),
            'username' => $request->getSession()->get('otp.username')
        ];
    }

    public function checkCredentials($credentails, UserInterface $user)
    {
        if (array_key_exists('code', $credentails)) {
            $otp = 123;

            return '123';
        }

        return $this->parent->checkCredentials($credentails, $user);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->hasSession()) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        }

        return new RedirectResponse($this->generator->generate('otp_security_check'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($this->parent->supports($request)) {
            $request->getSession()->set('otp.username', $token->getUsername());
            $request->getSession()->set('otp.checked', false);
        } else {
            $request->getSession()->set('otp.checked', false);
        }

        return $this->parent->onAuthenticationSuccess($request, $token, $providerKey);
    }
}
