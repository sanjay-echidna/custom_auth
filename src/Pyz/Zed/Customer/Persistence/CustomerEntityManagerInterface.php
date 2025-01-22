<?php

namespace Pyz\Zed\Customer\Persistence;
use Generated\Shared\Transfer\SsoTransfer;

interface CustomerEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     * @return \Generated\Shared\Transfer\SsoTransfer
     */
    public function validateSsoToken(SsoTransfer $ssoTransfer): SsoTransfer;
}