<?php

namespace Pyz\Client\Customer\Zed;

use Generated\Shared\Transfer\SsoTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class CustomerZedStub extends ZedRequestStub implements CustomerZedStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     *
     * @return \Generated\Shared\Transfer\SsoTransfer
     */
    public function validateSsoToken(SsoTransfer $ssoTransfer): SsoTransfer
    {
        return $this->zedStub->call('/customer/gateway/validate-sso-token', $ssoTransfer);
    }
}