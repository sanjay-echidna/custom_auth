<?php

namespace Pyz\Client\CustomAuth\Zed;

use Generated\Shared\Transfer\SsoTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class CustomAuthZedStub extends ZedRequestStub implements CustomAuthZedStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     *
     * @return \Generated\Shared\Transfer\SsoTransfer
     */
    public function validateSsoToken(SsoTransfer $ssoTransfer): SsoTransfer
    {
        return $this->zedStub->call('/Customer/gateway/validate-sso-token', $ssoTransfer);
    }
}