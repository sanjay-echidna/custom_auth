<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AIImageToProductGui;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class AIImageToProductGuiDependencyProvider extends AbstractBundleDependencyProvider
{
 /**
  * @var string
  */
    public const IMAGE_TO_TEXT_CLIENT = 'IMAGE_TO_TEXT_CLIENT';

    /**
     * @var string
     */
    public const QUERY_CONTAINER_PRODUCT = 'QUERY_CONTAINER_PRODUCT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addImageToTextClient($container);

        $container->set(static::QUERY_CONTAINER_PRODUCT, function (Container $container) {
            return $container->getLocator()->product()->queryContainer();
        });


        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addImageToTextClient(Container $container): Container
    {
        $container->set(static::IMAGE_TO_TEXT_CLIENT, function (Container $container) {
            return $container->getLocator()->imageToText()->client();
        });

        return $container;
    }
}
