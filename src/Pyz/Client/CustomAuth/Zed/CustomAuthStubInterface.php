<?php

namespace Pyz\Client\CustomAuth\Zed;

use Generated\Shared\Transfer\SsoTransfer;

interface CustomAuthZedStubInterface
{
    /**
     * Validates the SSO token.
     *
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     *
     * @return \Generated\Shared\Transfer\SsoTransfer
     */
    public function validateSsoToken(SsoTransfer $ssoTransfer): SsoTransfer;
}