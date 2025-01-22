<?php

declare(strict_types = 1);

namespace Pyz\Yves\SnapFind\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class SnapFindRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    /**
     * @var string
     */
    public const ROUTE_NAME = 'SnapFind';

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addIndexRoute($routeCollection);

        return $routeCollection;
    }


    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addIndexRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/snap-find', 'SnapFind', 'SnapFind', 'indexAction');
        $routeCollection->add(static::ROUTE_NAME, $route);

        return $routeCollection;
    }
}
