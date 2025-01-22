<?php

namespace Pyz\Client\CustomAuth;

use Generated\Shared\Transfer\SSoTransfer;

interface CustomAuthClientInterface
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
    public function validateSsoToken(SSoTransfer $ssoTransfer): SSoTransfer;
}