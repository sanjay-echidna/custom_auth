<?php

declare(strict_types = 1);

namespace Pyz\Client\SnapFind;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\StorageRedis\StorageRedisClientInterface;

class SnapFindDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT_STORAGE_REDIS = 'CLIENT_STORAGE_REDIS';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {

        $container = parent::provideServiceLayerDependencies($container);
        $container = $this->addStorageRedisClient($container);

        return $container;
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
