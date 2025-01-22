<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Customer\Business;

use Generated\Shared\Transfer\SsoTransfer;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface as SprykerCustomerFacadeInterface;

interface CustomerFacadeInterface extends SprykerCustomerFacadeInterface
{
  /**
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function validateSsoToken(SsoTransfer $ssoTransfer):SsoTransfer;
}
