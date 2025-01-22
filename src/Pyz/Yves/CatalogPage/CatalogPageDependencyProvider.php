<?php

namespace Pyz\Yves\CatalogPage;

use Spryker\Client\StorageRedis\StorageRedisClientInterface;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\CatalogPage\CatalogPageDependencyProvider as SprykerCatalogPageDependencyProvider;

class CatalogPageDependencyProvider extends SprykerCatalogPageDependencyProvider
{

    /**
     * @var string
     */
    public const CLIENT_STORAGE_REDIS = 'CLIENT_STORAGE_REDIS';

    /**
     * @param Container $container
     * @return Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addStorageRedisClient($container);

        return parent::provideDependencies($container);
    }

    /**
     * @param Container $container
     * @return Container
     */
    private function addStorageRedisClient(Container $container): Container
    {
        $container->set(static::CLIENT_STORAGE_REDIS, static function (Container $container): StorageRedisClientInterface {
            return $container->getLocator()->storageRedis()->client();
        });

        return $container;
    }


}
