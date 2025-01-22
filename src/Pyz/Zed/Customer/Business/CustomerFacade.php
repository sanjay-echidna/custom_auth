<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Customer\Business;
use Generated\Shared\Transfer\SsoTransfer;
use Spryker\Zed\Customer\Business\CustomerFacade as SprykerCustomerFacade;

/**
 * @method \Pyz\Zed\Customer\Business\CustomerBusinessFactory getFactory()
 * @method \Pyz\Zed\Customer\Persistence\CustomerEntityManagerInterface getEntityManager()
 */
class CustomerFacade extends SprykerCustomerFacade implements CustomerFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function validateSsoToken(SsoTransfer $ssoTransfer):SsoTransfer
    {
        return $this->getEntityManager()->validateSsoToken( $ssoTransfer);
    }
}
