<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\CustomAuth;

use Pyz\Client\CustomAuth\Zed\CustomAuthZedStub;
use Pyz\Client\CustomAuth\Zed\CustomAuthZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

/**
 * @method \Pyz\Client\CustomAuth\CustomAuthConfig getConfig()
 */
class CustomAuthFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Client\CustomAuth\Zed\CustomAuthZedStubInterface
     */
    public function createStub(): CustomAuthZedStubInterface
    {
        return new CustomAuthZedStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(CustomAuthDependencyProvider::SERVICE_ZED);
    }
}
