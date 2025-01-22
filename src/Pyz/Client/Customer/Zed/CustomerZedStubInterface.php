<?php

namespace Pyz\Client\Customer\Zed;

use Generated\Shared\Transfer\SsoTransfer;

interface CustomerZedStubInterface
{
    /**
     * Validates the SSO token.
     *
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     *
     * @return bool
     */
    /**
     * Validates the SSO token.
     *
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     *
     * @return \Generated\Shared\Transfer\SsoTransfer
     */
    public function validateSsoToken(SsoTransfer $ssoTransfer): SsoTransfer;
}