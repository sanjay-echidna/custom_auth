<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Customer\Communication\Controller;
use Generated\Shared\Transfer\SsoTransfer;
use Spryker\Zed\Customer\Communication\Controller\GatewayController as SprykerGatewayController;

/**
 * @method \Pyz\Zed\Customer\Business\CustomerFacadeInterface getFacade()
 */
class GatewayController extends SprykerGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function validateSsoTokenAction(SsoTransfer $ssoTransfer)
    {
        return $this->getFacade()->validateSsoToken( $ssoTransfer);
    }

}
