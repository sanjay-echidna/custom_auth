<?php

namespace Pyz\Yves\CustomAuth\Plugin\Security;

use LogicException;
use Psr\Log\LoggerInterface;
use Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface;
use Spryker\Service\Container\ContainerInterface;
use Spryker\Yves\Security\Loader\AuthenticatorManager\AuthenticatorManager;
use SprykerShop\Yves\CustomerPage\Plugin\Security\YvesCustomerPageSecurityPlugin;
use Symfony\Component\Security\Guard\Firewall\GuardAuthenticationListener;
use Symfony\Component\Security\Guard\Provider\GuardAuthenticationProvider;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;

/**
 *
 * @method \SprykerShop\Yves\CustomerPage\CustomerPageConfig getConfig()
 * @method \Pyz\Yves\CustomAuth\CustomAuthFactory getFactory()
 */
class YvesCustomAuthSecurityPlugin extends YvesCustomerPageSecurityPlugin
{

    /**
     * @var string
     */
    protected const SECURITY_CUSTOMER_CUSTOM_AUTHENTICATOR = 'security.secured.custom.authenticator';

    /**
     * @var string
     */
    protected const SERVICE_SECURITY_AUTHENTICATION_LISTENER_GUARD_PROTO = 'security.authentication_listener.guard._proto';

    /**
     * @var string
     */
    protected const SERVICE_SECURITY_AUTHENTICATION_GUARD_HANDLER = 'security.authentication.guard_handler';

    /**
     * @var string
     */
    protected const SERVICE_SECURITY_AUTHENTICATION_PROVIDER_GUARD_PROTO = 'security.authentication_provider.guard._proto';

    /**
     * @var string
     */
    protected const SERVICE_SECURITY_ENTRY_POINT_GUARD_PROTO = 'security.entry_point.guard._proto';

    /**
     * @var string
     */
    protected const SERVICE_SECURITY_AUTHENTICATION_MANAGER = 'security.authentication_manager';

    /**
     * @var string
     */
    protected const SERVICE_SECURITY_USER_CHECKER = 'security.user_checker';

    /**
     * @var string
     */
    protected const SERVICE_SECURITY_TOKEN_STORAGE = 'security.token_storage';

    /**
     * @param \Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface $securityBuilder
     *
     * @return \Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface
     */

    /**
     * @var string
     */
    protected const SERVICE_LOGGER = 'logger';

    /**
     * @uses \Spryker\Zed\EventDispatcher\Communication\Plugin\Application\EventDispatcherApplicationPlugin::SERVICE_DISPATCHER
     *
     * @var string
     */
    protected const SERVICE_DISPATCHER = 'dispatcher';

    /**
     * @var string
     */
    protected const SERVICE_SECURITY_AUTHENTICATION_PROVIDERS = 'security.authentication_providers';
    
     /*
    protected function addFirewalls(SecurityBuilderInterface $securityBuilder): SecurityBuilderInterface
    {
        return $securityBuilder->addFirewall(
            SharedCustomerPageConfig::SECURITY_FIREWALL_NAME,
            [
                'anonymous'=>true,
                'pattern' => '^/(en|de|fr)/custom/sso/[a-zA-Z0-9]+$',
                // 'form' => [
                //     'login_path' => '/custom/sso/',
                //     // 'check_path' => static::HOMEPAGE_PATH . '/login_check',
                //     'authenticators' => [
                //         static::SECURITY_CUSTOMER_CUSTOM_AUTHENTICATOR,
                //     ],
                  // ],
                'guard' => [
                    'authenticators' => [
                        static::SECURITY_CUSTOMER_CUSTOM_AUTHENTICATOR,
                    ],
                ],
                'stateless'=> false,
                // 'authenticator' => static::SECURITY_CUSTOMER_LOGIN_FORM_AUTHENTICATOR,
                'users' => function () {
                    return new CustomerUserProvider();
                },
                'logout' => [
                    'logout_path' => '/logout',
                    'target_url' => '/',
                ],
            ]
        );
    }
    */
    
     /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return void
     */
    // protected function addAuthenticator(ContainerInterface $container): void
    // {
    //     $container->set(static::SECURITY_CUSTOMER_CUSTOM_AUTHENTICATOR, function () {
    //         return $this->authenticator;
    //     });
    // }

    /**
     * Custom implementation of the extend method.
     *
     * @param \Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface $securityBuilder
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface
     */
    public function extend(SecurityBuilderInterface $securityBuilder, ContainerInterface $container): SecurityBuilderInterface
    {   
        $container = $this->addEntryPointGuardPrototype($container);

        $container = $this->addAuthenticationProviderGuardPrototype($container);
        $container = $this->addAuthenticationListenerGuardPrototype($container);
        //$container = $this->addAuthenticationManager($container);
        
        return $this->getFactory()->createSecurityBuilderExpander()->extend($securityBuilder, $container);
    }
    

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    // protected function addAuthenticationManager(ContainerInterface $container): ContainerInterface
    // {
    //     $container->set(static::SERVICE_SECURITY_AUTHENTICATION_MANAGER, function (ContainerInterface $container) {
    //         $manager = new AuthenticationProviderManager($container->get(static::SERVICE_SECURITY_AUTHENTICATION_PROVIDERS));
    //         $manager->setEventDispatcher($container->get(static::SERVICE_DISPATCHER));

    //         return $manager;
    //     });

    //     return $container;
    // }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    protected function addAuthenticationListenerGuardPrototype(ContainerInterface $container): ContainerInterface
    {
        $container->set(static::SERVICE_SECURITY_AUTHENTICATION_LISTENER_GUARD_PROTO, $container->protect(function ($providerKey, $options) use ($container) {
            return function () use ($container, $providerKey, $options) {
                if (!$container->has(static::SERVICE_SECURITY_AUTHENTICATION_GUARD_HANDLER)) {
                    $container->set(static::SERVICE_SECURITY_AUTHENTICATION_GUARD_HANDLER, new GuardAuthenticatorHandler($container->get(static::SERVICE_SECURITY_TOKEN_STORAGE), $container->get(static::SERVICE_DISPATCHER)));
                }
                $authenticators = [];
                foreach ($options['authenticators'] as $authenticatorId) {
                    $authenticators[] = $container->get($authenticatorId);
                }

                $authenticationManager = $container->get(static::SERVICE_SECURITY_AUTHENTICATION_MANAGER);
                if ($authenticationManager instanceof \Closure) {
                    $resolved = $authenticationManager('custom_sso',[]); // Resolve the closure
                    dd($resolved);
                }

                //dd($authenticationManager);

                return new GuardAuthenticationListener(
                    $container->get(static::SERVICE_SECURITY_AUTHENTICATION_GUARD_HANDLER),
                    $container->get(static::SERVICE_SECURITY_AUTHENTICATION_MANAGER),
                    $providerKey,
                    $authenticators,
                    $this->getLogger($container),
                );
            };
        }));

        return $container;
    }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    protected function addAuthenticationProviderGuardPrototype(ContainerInterface $container): ContainerInterface
    {
        $container->set(static::SERVICE_SECURITY_AUTHENTICATION_PROVIDER_GUARD_PROTO, $container->protect(function ($name, $options) use ($container) {
            return static function () use ($container, $name, $options) {
                $authenticators = [];
                foreach ($options['authenticators'] as $authenticatorId) {
                    $authenticators[] = $container->get($authenticatorId);
                }

                return new GuardAuthenticationProvider(
                    $authenticators,
                    $container->get('security.user_provider.' . $name),
                    $name,
                    $container->get(static::SERVICE_SECURITY_USER_CHECKER),
                );
            };
        }));

        return $container;
    }

      /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    protected function addEntryPointGuardPrototype(ContainerInterface $container): ContainerInterface
    {
        $container->set(static::SERVICE_SECURITY_ENTRY_POINT_GUARD_PROTO, $container->protect(function ($name, array $options) use ($container) {
            if (isset($options['entry_point'])) {
                return $container->get($options['entry_point']);
            }

            $authenticatorIds = $options['authenticators'];

            if (count($authenticatorIds) === 1) {
                return $container->get(reset($authenticatorIds));
            }

            throw new LogicException(sprintf(
                'Because you have multiple guard configurators, you need to set the "guard.entry_point" key to one of your configurators (%s)',
                implode(', ', $authenticatorIds),
            ));
        }));

        return $container;
    }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Psr\Log\LoggerInterface|null
     */
    protected function getLogger(ContainerInterface $container): ?LoggerInterface
    {
        return $container->has(static::SERVICE_LOGGER) ? $container->get(static::SERVICE_LOGGER) : null;
    }
    
}
