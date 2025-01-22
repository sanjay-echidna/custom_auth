<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CheckoutB2B\Communication\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutDoSaveOrderInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\CheckoutB2B\Business\CheckoutB2BFacadeInterface getFacade()
 * @method \Pyz\Zed\CheckoutB2B\Communication\CheckoutB2BCommunicationFactory getFactory()
 * @method \Pyz\Zed\CheckoutB2B\Persistence\CheckoutB2BQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\CheckoutB2B\CheckoutB2BConfig getConfig()
 */
class CustomerPoNumberOrderSaverPlugin extends AbstractPlugin implements CheckoutDoSaveOrderInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrder(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer)
    {
        $this->getFacade()->saveCustomerPoNumberForCheckout($quoteTransfer, $saveOrderTransfer);
    }
}
