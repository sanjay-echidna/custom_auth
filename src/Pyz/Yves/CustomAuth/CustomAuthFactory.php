<?php

namespace Pyz\Yves\CustomAuth;

use Pyz\Yves\CustomAuth\Authenticator\CustomAuthenticator;
use Pyz\Yves\CustomAuth\Provider\CustomAuthenticationFailureHandler;
use Spryker\Yves\Router\Router\ChainRouter;
use SprykerShop\Yves\CustomerPage\Plugin\Provider\AccessDeniedHandler;
use SprykerShop\Yves\CustomerPage\Plugin\Provider\CustomerAuthenticationFailureHandler;
use SprykerShop\Yves\CustomerPage\Plugin\Provider\CustomerAuthenticationSuccessHandler;
use SprykerShop\Yves\CustomerPage\Plugin\Provider\CustomerUserProvider;
use SprykerShop\Yves\CustomerPage\Plugin\Subscriber\InteractiveLoginEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Spryker\Client\Session\SessionClientInterface;
use SprykerShop\Yves\CustomerPage\CustomerPageFactory as SprykerCustomerPageFactory;
use Pyz\Yves\CustomAuth\Expander\SecurityBuilderExpander;
use Pyz\Yves\CustomAuth\Provider\CustomAuthenticationSuccessHandler;
use Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface;
use SprykerShop\Yves\CustomerPage\Builder\CustomerSecurityOptionsBuilder;
use SprykerShop\Yves\CustomerPage\Builder\CustomerSecurityOptionsBuilderInterface;
use SprykerShop\Yves\CustomerPage\CustomerPageConfig;
use SprykerShop\Yves\CustomerPage\Expander\SecurityBuilderExpanderInterface;
use SprykerShop\Yves\CustomerPage\Formatter\LoginCheckUrlFormatter;
use SprykerShop\Yves\CustomerPage\Formatter\LoginCheckUrlFormatterInterface;
use SprykerShop\Yves\CustomerPage\Plugin\Security\CustomerPageSecurityPlugin;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;

/**
 * method \SprykerShop\Yves\CustomerPage\CustomerPageConfig getConfig()
 * 
 */
class CustomAuthFactory extends SprykerCustomerPageFactory
{
    // public function getCustomerClient()
    // {
    //     return $this->getProvidedDependency(CustomAuthDependencyProvider::CLIENT_CUSTOMER);
    // }

        /**
     * @return \Symfony\Component\EventDispatcher\EventSubscriberInterface
     */
    public function createInteractiveLoginEventSubscriber(): EventSubscriberInterface
    {
        return new InteractiveLoginEventSubscriber();
    }

    /**
     * @return \SprykerShop\Yves\CustomerPage\Plugin\Provider\CustomerAuthenticationSuccessHandler
     */
    public function createCustomerAuthenticationSuccessHandler()
    {
        return new CustomAuthenticationSuccessHandler();
    }

    /**
     * @param string|null $targetUrl
     *
     * @return \SprykerShop\Yves\CustomerPage\Plugin\Provider\CustomerAuthenticationFailureHandler
     */
    public function createCustomerAuthenticationFailureHandler(?string $targetUrl = null)
    {
        return new CustomAuthenticationFailureHandler($targetUrl);
    }

    /**
     * @return \Symfony\Component\Security\Core\User\UserProviderInterface
     */
    public function createCustomerUserProvider()
    {
        return new CustomerUserProvider();
    }

    /**
     * @param string $targetUrl
     *
     * @return \Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface
     */
    public function createAccessDeniedHandler(string $targetUrl): AccessDeniedHandlerInterface
    {
        return new AccessDeniedHandler($targetUrl);
    }

     /**
     * @param string $targetUrl
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createRedirectResponse($targetUrl)
    {
        return new RedirectResponse($targetUrl);
    }


    /**
     * @return \Spryker\Yves\Router\Router\ChainRouter
     */
    public function getRouter(): ChainRouter
    {
        return $this->getProvidedDependency(CustomAuthDependencyProvider::SERVICE_ROUTER);
    }

        /**
     * @return \SprykerShop\Yves\CustomerPage\Expander\SecurityBuilderExpanderInterface
     */
    public function createSecurityBuilderExpander(): SecurityBuilderExpanderInterface
    {
        // Ensure compatibility by maintaining the expected return type
        if (class_exists(AuthenticationProviderManager::class)) {
            return new CustomerPageSecurityPlugin();
        }

        return new SecurityBuilderExpander(
            $this->createCustomerSecurityOptionsBuilder(),
            $this->getCustomerClient(),
            $this->getCustomerConfig(),
            $this->createInteractiveLoginEventSubscriber(),
            $this->createCustomerLoginAuthenticator(),
            $this->createUserCheckerListener(),
        );
    }

    /**
     * @return \Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface
     */
    public function createCustomerLoginAuthenticator(): AuthenticatorInterface
    {
        return new CustomAuthenticator(
            $this->createCustomerUserProvider(),
            $this->createCustomerAuthenticationSuccessHandler(),
            $this->createCustomerAuthenticationFailureHandler(),
            $this->getRouter(),
        );
    }

    // /**
    //  * @return \SprykerShop\Yves\CustomerPage\Builder\CustomerSecurityOptionsBuilderInterface
    //  */
    // public function createCustomerSecurityOptionsBuilder(): CustomerSecurityOptionsBuilderInterface
    // {
    //     return new CustomerSecurityOptionsBuilder(
    //         $this->getConfig(),
    //         $this->createCustomerUserProvider(),
    //         $this->createLoginCheckUrlFormatter(),
    //     );
    // }

    /**
     * @return \SprykerShop\Yves\CustomerPage\Formatter\LoginCheckUrlFormatterInterface
     */
    public function createLoginCheckUrlFormatter(): LoginCheckUrlFormatterInterface
    {
        return new LoginCheckUrlFormatter($this->getCustomerConfig(), $this->getLocale());
    }

    /**
     * @return \SprykerShop\Yves\CustomerPage\Builder\CustomerSecurityOptionsBuilderInterface
     */
    public function createCustomerSecurityOptionsBuilder(): CustomerSecurityOptionsBuilderInterface
    {
        return new CustomerSecurityOptionsBuilder(
            $this->getCustomerConfig(),
            $this->createCustomerUserProvider(),
            $this->createLoginCheckUrlFormatter(),
        );
    }
    
    /**
     * Method getCustomerConfig
     *
     * @return CustomerPageConfig
     */
    public function getCustomerConfig()
    {
        return new CustomerPageConfig();
    }
}
