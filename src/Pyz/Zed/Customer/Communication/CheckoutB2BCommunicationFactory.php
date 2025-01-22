<?php

declare(strict_types = 1);

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CheckoutB2B\Communication;

use Pyz\Zed\CheckoutB2B\CheckoutB2BDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Payment\Business\PaymentFacadeInterface;
use Spryker\Zed\Shipment\Business\ShipmentFacadeInterface;

/**
 * @method \Pyz\Zed\CheckoutB2B\CheckoutB2BConfig getConfig()
 * @method \Pyz\Zed\CheckoutB2B\Business\CheckoutB2BFacadeInterface getFacade()
 * @method \Pyz\Zed\CheckoutB2B\Persistence\CheckoutB2BRepositoryInterface getRepository()
 * @method \Pyz\Zed\CheckoutB2B\Persistence\CheckoutB2BEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\CheckoutB2B\Persistence\CheckoutB2BQueryContainerInterface getQueryContainer()
 */
class CheckoutB2BCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Spryker\Zed\Payment\Business\PaymentFacadeInterface
     */
    public function getPaymentFacade(): PaymentFacadeInterface
    {
        return $this->getProvidedDependency(CheckoutB2BDependencyProvider::FACADE_PAYMENT);
    }

    /**
     * @return \Spryker\Zed\Shipment\Business\ShipmentFacadeInterface
     */
    public function getShipmentFacade(): ShipmentFacadeInterface
    {
        return $this->getProvidedDependency(CheckoutB2BDependencyProvider::FACADE_SHIPMENT);
    }

    /**
     * @return string
     */
    public function getRoutingGuideShipmentMethod(): string
    {
        return $this->getConfig()->getRoutingGuideShipmentMethod();
    }
}
