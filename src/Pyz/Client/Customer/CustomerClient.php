<?php

namespace Pyz\Client\Customer;

use Generated\Shared\Transfer\SSoTransfer;
use Spryker\Client\Customer\CustomerClient as SpyCustomerClient;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\Customer\CustomerFactory getFactory()
 */
class CustomerClient extends SpyCustomerClient implements CustomerClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SSoTransfer $ssoTransfer
     *
     * @return bool
     */
    public function validateSsoToken(SSoTransfer $ssoTransfer): SSoTransfer
    {
        return $this->getFactory()
            ->createStub()
            ->validateSsoToken($ssoTransfer);
    }
}
