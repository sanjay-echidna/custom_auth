<?php

declare(strict_types = 1);

namespace Pyz\Client\SnapFind;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Pyz\Yves\CatalogPage\CatalogPageDependencyProvider;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\StorageRedis\StorageRedisClientInterface;

/**
 * @method \Pyz\Client\SnapFind\SnapFindConfig getConfig()
 */
class SnapFindFactory extends AbstractFactory
{
    /**
     * @return ClientInterface
     */
    public function createGuzzleClient(): ClientInterface
    {
        return new Client();
    }

    /**
     * @return StorageRedisClientInterface
     */
    public function getStorageRedisClient(): StorageRedisClientInterface
    {
        return $this->getProvidedDependency(SnapFindDependencyProvider::CLIENT_STORAGE_REDIS);
    }

}
