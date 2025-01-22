<?php

namespace Pyz\Yves\CustomAuth\Authenticator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Spryker\Yves\Router\Router\ChainRouter;
use SprykerShop\Yves\CustomerPage\Authenticator\CustomerLoginFormAuthenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class CustomAuthenticator implements AuthenticatorInterface, AuthenticationEntryPointInterface
{
    
    /**
     * @uses \SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin::ROUTE_LOGIN
     *
     * @var string
     */
    protected const ROUTE_LOGIN = 'custom/sso/';

    private const METHOD = "AES-256-CBC";
    private const KEY = "encryptionKey123encryptionKey123";
    private const OPTIONS = 0;
    private const IV = '1234567891011121';

    /**
     * @var \Symfony\Component\Security\Core\User\UserProviderInterface
     */
    protected UserProviderInterface $userProvider;

    /**
     * @var \Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface
     */
    protected AuthenticationSuccessHandlerInterface $authenticationSuccessHandler;

    /**
     * @var \Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface
     */
    protected AuthenticationFailureHandlerInterface $authenticationFailureHandler;

    /**
     * @var \Spryker\Yves\Router\Router\ChainRouter
     */
    protected ChainRouter $router;

    /**
     * @param \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider
     * @param \Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge $rememberMeBadge
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface $authenticationSuccessHandler
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface $authenticationFailureHandler
     * @param \Spryker\Yves\Router\Router\ChainRouter $router
     */
    public function __construct(
        UserProviderInterface $userProvider,
        AuthenticationSuccessHandlerInterface $authenticationSuccessHandler,
        AuthenticationFailureHandlerInterface $authenticationFailureHandler,
        ChainRouter $router
    ) {
        $this->userProvider = $userProvider;
        $this->authenticationSuccessHandler = $authenticationSuccessHandler;
        $this->authenticationFailureHandler = $authenticationFailureHandler;
        $this->router = $router;
    }

    public function supports(Request $request): ?bool
    {   
        if (preg_match('#^/en/custom/sso/[a-zA-Z0-9]+$#', $request->getPathInfo())) {
            // Ensure the 'token' attribute is present in the request
            return $request->attributes->has('token');
        } 
        return false;
    }

    public function authenticate(Request $request): Passport
    {
        $token = $request->attributes->get('token');
        if (!$token) {
            throw new AuthenticationException('No token provided.');
        }
        
        $email = $this->decryptToken($token);

        if (!$email) {
            throw new AuthenticationException('Invalid token.');
        }

        return new SelfValidatingPassport(
            new UserBadge($email, function (string $userEmail) {
                return $this->userProvider->loadUserByIdentifier($userEmail);
            })
        );
    }
    
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException|null $authException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function start(Request $request, ?AuthenticationException $authException = null): RedirectResponse
    {
        return new RedirectResponse($this->router->generate(static::ROUTE_LOGIN));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {  
        return $this->authenticationSuccessHandler->onAuthenticationSuccess($request, $token);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return $this->authenticationFailureHandler->onAuthenticationFailure($request, $exception);
    }
    
    /**
     * Method decryptToken
     *
     * @param string $token
     *
     * @return string
     */
    private function decryptToken(string $token): ?string
    {
        $token = base64_encode(hex2bin($token));
        $decryptedData = openssl_decrypt($token, self::METHOD, self::KEY, self::OPTIONS, self::IV);
        return $decryptedData;
    }
    /**
     * Method encryptToken
     *
     * @param string $data
     *
     * @return string
     */
    private function encryptToken(string $data): string
    {
        return openssl_encrypt($data, self::METHOD, self::KEY, self::OPTIONS, self::IV);
    }

    /**
     * @param \Symfony\Component\Security\Http\Authenticator\Passport\Passport $passport
     * @param string $firewallName
     *
     * @return \Symfony\Component\Security\Core\Authentication\Token\TokenInterface
     */
    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        return new PostAuthenticationToken(
            $passport->getUser(),
            $firewallName,
            $passport->getUser()->getRoles(),
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException|null $authException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    // public function start(Request $request, ?AuthenticationException $authException = null): RedirectResponse
    // {
    //     return new RedirectResponse($this->router->generate(static::ROUTE_LOGIN));
    // }

    /**
     * @param \Symfony\Component\Security\Http\Authenticator\Passport\Passport $passport
     * @param string $firewallName
     *
     * @return \Symfony\Component\Security\Core\Authentication\Token\TokenInterface
     */
    // public function createToken(Passport $passport, string $firewallName): TokenInterface
    // {
    //     return new PostAuthenticationToken(
    //         $passport->getUser(),
    //         $firewallName,
    //         $passport->getUser()->getRoles(),
    //     );
    // }
}
