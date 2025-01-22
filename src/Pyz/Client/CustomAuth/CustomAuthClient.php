<?php

namespace Pyz\Client\CustomAuth;

use Generated\Shared\Transfer\SSoTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\CustomAuth\CustomAuthFactory getFactory()
 */
class CustomAuthClient extends AbstractClient implements CustomAuthClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SSoTransfer $ssoTransfer
     *
     * @return SSoTransfer
     */
    public function validateSsoToken(SSoTransfer $ssoTransfer): SSoTransfer
    {
        return $this->getFactory()
            ->createStub()
            ->validateSsoToken($ssoTransfer);
    }
}
