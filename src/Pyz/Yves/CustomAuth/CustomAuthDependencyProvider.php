<?php

namespace Pyz\Yves\CustomAuth;

use Pyz\Yves\CustomerPage\CustomerPageDependencyProvider;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\CustomerPage\Security\Customer;

class CustomAuthDependencyProvider extends CustomerPageDependencyProvider
{
    //public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';
    /**
     * @uses \Spryker\Yves\Router\Plugin\Application\RouterApplicationPlugin::SERVICE_ROUTER
     *
     * @var string
     */
    public const SERVICE_ROUTER = 'routers';
    public const SERVICE_TOKEN_STORAGE = 'security.token_storage';


    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        //$container = $this->addCustomerClient($container);
        $container = $this->addRouter($container);
        //$container =  $this->addTokenStorage($container);
        return $container;
    }

    /**
     * Add TokenStorage service to the container.
     *
     * @param \Spryker\Yves\Kernel\Container $container
     */
    public function addTokenStorage(Container $container): Container
    {
        // Adding TokenStorage to the container as a service.
        // This is useful if you want to inject it into other services.
        return $container->set(self::SERVICE_TOKEN_STORAGE, function (Container $container) {
            // Accessing the token storage from the Symfony container
            return $container->get(self::SERVICE_TOKEN_STORAGE);
        });
    }

    // protected function addCustomerClient(Container $container): Container
    // {
    //     $container[static::CLIENT_CUSTOMER] = function (Container $container) {
    //         return $container->getLocator()->customer()->client();
    //     };

    //     return $container;
    // }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addRouter(Container $container): Container
    {
        $container->set(static::SERVICE_ROUTER, function (Container $container) {
            return $container->getApplicationService(static::SERVICE_ROUTER);
        });

        return $container;
    }
}
