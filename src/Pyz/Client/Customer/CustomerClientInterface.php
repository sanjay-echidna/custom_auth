<?php

namespace Pyz\Client\Customer;

use Generated\Shared\Transfer\SSoTransfer;

interface CustomerClientInterface
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
    public function validateSsoToken(SSoTransfer $ssoTransfer): SSoTransfer;
}