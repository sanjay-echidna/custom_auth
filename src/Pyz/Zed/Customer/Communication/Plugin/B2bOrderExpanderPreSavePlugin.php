<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CheckoutB2B\Communication\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Sales\Dependency\Plugin\OrderExpanderPreSavePluginInterface;

/**
 * @method \Pyz\Zed\CheckoutB2B\Business\CheckoutB2BFacadeInterface getFacade()
 * @method \Pyz\Zed\CheckoutB2B\Communication\CheckoutB2BCommunicationFactory getFactory()
 * @method \Pyz\Zed\CheckoutB2B\Persistence\CheckoutB2BQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\CheckoutB2B\CheckoutB2BConfig getConfig()
 */
class B2bOrderExpanderPreSavePlugin extends AbstractPlugin implements OrderExpanderPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\SpySalesOrderEntityTransfer $salesOrderEntityTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\SpySalesOrderEntityTransfer
     */
    public function expand(SpySalesOrderEntityTransfer $salesOrderEntityTransfer, QuoteTransfer $quoteTransfer): SpySalesOrderEntityTransfer
    {
        return $this->getFacade()->expandB2bOrderData($salesOrderEntityTransfer, $quoteTransfer);
    }
}
