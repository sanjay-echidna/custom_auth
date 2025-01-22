<?php

namespace Pyz\Yves\CustomAuth\Expander;

use Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface;
use Spryker\Service\Container\ContainerInterface;
use SprykerShop\Shared\CustomerPage\CustomerPageConfig as SharedCustomerPageConfig;
use SprykerShop\Yves\CustomerPage\Expander\SecurityBuilderExpander as SprykerSecurityBuilderExpander;
use SprykerShop\Yves\CustomerPage\Plugin\Provider\CustomerUserProvider;

class SecurityBuilderExpander extends SprykerSecurityBuilderExpander
{
    /**
     * @var string
     */
    protected const SECURITY_CUSTOMER_CUSTOM_AUTHENTICATOR = 'security.secured.custom.authenticator';
    protected const SECURITY_FIREWALL_NAME = 'custom_sso';
    protected const ROUTE_LOGOUT = '/logout';

    /**
     * @param \Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface $securityBuilder
     *
     * @return \Spryker\Shared\SecurityExtension\Configuration\SecurityBuilderInterface
     */
    protected function addFirewalls(SecurityBuilderInterface $securityBuilder): SecurityBuilderInterface
    {
        return $securityBuilder->addFirewall(
            static::SECURITY_FIREWALL_NAME,
            [
                // 'anonymous' => true,
                // 'pattern' => '^/(en|de|fr)/custom/sso/[a-zA-Z0-9]+$',
                'pattern' => '^/',
                'guard' => [
                    'authenticators' => [
                        static::SECURITY_CUSTOMER_CUSTOM_AUTHENTICATOR,
                    ],
                ],
                'security' => true,
                'stateless'=> false,
                // 'authenticator' => static::SECURITY_CUSTOMER_LOGIN_FORM_AUTHENTICATOR,
                'users' => function () {
                    return new CustomerUserProvider();
                },
                'logout' => [
                    'logout_path' => static::ROUTE_LOGOUT,
                    'target_url' => '/',
                ],
            ]
        );
    }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return void
     */
    protected function addAuthenticator(ContainerInterface $container): void
    {
        $container->set(static::SECURITY_CUSTOMER_CUSTOM_AUTHENTICATOR, function () {
            return $this->authenticator;
        });
    }
}
