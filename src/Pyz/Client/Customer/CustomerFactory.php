<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\Customer;

use Pyz\Client\Customer\Zed\CustomerZedStub;
use Pyz\Client\Customer\Zed\CustomerZedStubInterface;
use Spryker\Client\Customer\CustomerFactory as SpyCustomerFactory;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

/**
 * @method \Pyz\Client\Customer\CustomerConfig getConfig()
 */
class CustomerFactory extends SpyCustomerFactory
{
    /**
     * @return \Pyz\Client\Customer\Zed\CustomerZedStubInterface
     */
    public function createStub(): CustomerZedStubInterface
    {
        return new CustomerZedStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::SERVICE_ZED);
    }
}
