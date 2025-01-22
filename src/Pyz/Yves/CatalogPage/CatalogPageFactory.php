<?php

namespace Pyz\Yves\CatalogPage;

use Spryker\Client\StorageRedis\StorageRedisClientInterface;
use SprykerShop\Yves\CatalogPage\CatalogPageFactory as SprykerCatalogPageFactory;

class CatalogPageFactory extends SprykerCatalogPageFactory
{
    /**
     * @return StorageRedisClientInterface
     */
    public function getStorageRedisClient(): StorageRedisClientInterface
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::CLIENT_STORAGE_REDIS);
    }
}
