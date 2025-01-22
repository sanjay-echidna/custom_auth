<?php
namespace Pyz\Yves\CustomAuth\Plugin\Router;

use Spryker\Yves\Router\Route\RouteCollection;
use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin as BaseCustomerPageRouteProviderPlugin;

class CustomAuthPageRouteProviderPlugin extends BaseCustomerPageRouteProviderPlugin
{
    protected const ROUTE_NAME_SSO = 'customer-sso';

    /**
     * {@inheritDoc}
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = parent::addRoutes($routeCollection);

        // Add custom SSO route
        $routeCollection = $this->addSsoRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * Creates the SSO route.
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addSsoRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/custom/sso/{token}', 'CustomAuth', 'SSO', 'ssoAction');
        $routeCollection->add(static::ROUTE_NAME_SSO, $route);
    
        return $routeCollection;
    }
    
}
?>
