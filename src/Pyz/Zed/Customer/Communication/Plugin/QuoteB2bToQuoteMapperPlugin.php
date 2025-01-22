<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CheckoutB2B\Communication\Plugin;

use ArrayObject;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\B2bAddressTransfer;
use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentCarrierTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use Generated\Shared\Transfer\TaxTotalTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Pyz\Zed\CheckoutB2B\Dependency\Plugin\CheckoutB2bPrePlaceOrderInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\CheckoutB2B\Communication\CheckoutB2BCommunicationFactory getFactory()
 * @method \Pyz\Zed\CheckoutB2B\Business\CheckoutB2BFacadeInterface getFacade()
 * @method \Pyz\Zed\CheckoutB2B\Persistence\CheckoutB2BQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\CheckoutB2B\CheckoutB2BConfig getConfig()
 */
class QuoteB2bToQuoteMapperPlugin extends AbstractPlugin implements CheckoutB2bPrePlaceOrderInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function preSave(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $userType = $quoteTransfer->getCustomer()->getBannerUserType();
        if ($userType == 'b2c' || $userType == '') { // skip order entity expansion for B2C customers
            return $quoteTransfer;
        }

        $quoteTransfer->setShipment($this->buildShipmentTransfer($quoteTransfer));
        $quoteTransfer = $this->mapQuoteItems($quoteTransfer);
        $quoteTransfer = $this->mapBillingAddress($quoteTransfer);
        $quoteTransfer = $this->mapPayment($quoteTransfer);

        $quoteTransfer->setPoNumber($quoteTransfer->getQuoteB2bData()->getPoNumber())
            ->setCustomerPurchaseOrder($quoteTransfer->getQuoteB2bData()->getEndCustomerPo())
            ->setCustomerPoReferenceNumber($quoteTransfer->getQuoteB2bData()->getEndCustomerPo())
            ->setIsAddressSavingSkipped(true)
            ->setSkipRecalculation(true)
            ->setAcceptTermsAndConditions(true)
            ->setOrderSource('Spryker')
            ->setShippingAddress($this->mapB2bAddressToAddress($quoteTransfer->getQuoteB2bData()->getB2bShippingAddress()));

//Commented the avalara transaction plugin call here to move the b2b order through this plugin,can be uncommented if needed
//        $quoteTransfer->setAvalaraCreateTransactionResponse(
//            (new AvalaraCreateTransactionResponseTransfer())->setIsSuccessful(true)
//        );

        $quoteTransfer->setCollectAccount((string)$quoteTransfer->getQuoteB2bData()->getCollectAccount());

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    private function mapQuoteItems(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteItems = new ArrayObject();
        $grandTotal = 0;
        /**
         * @var array<string, mixed> $itemData
         */
        foreach ($quoteTransfer->getQofData() as $itemData) {
            $itemTransfer = (new ItemTransfer());
            $itemTransfer->setSku($itemData['sku'])
                ->setIsQuantitySplittable(false)//ref: https://docs.spryker.com/docs/pbc/all/order-management-system/202404.0/base-shop/order-management-feature-overview/splittable-order-items-overview.html
                ->setQuantity((int)$itemData['QUANTITY'])
                ->setCustomerPartNumber($itemData['CUSTOMER_PART_NUMBER'] ?? '')
                ->setName($itemData['name'])
                ->setUnitPrice((int)$itemData['UNIT_PRICE'] * 100)
                ->setUnitNetPrice((int)$itemData['UNIT_PRICE'] * 100)
                ->setSumPrice((int)$itemData['TOTAL_PRICE'] * 100)
                ->setSumNetPrice((int)$itemData['TOTAL_PRICE'] * 100)
                ->setGroupKey($itemData['PART_MODEL_NUMBER'])
                ->setUnitGrossPrice((int)$itemData['UNIT_PRICE'] * 100)
                ->setUnitExpensePriceAggregation(0)
                ->setSumExpensePriceAggregation(0)
                ->setAmount((int)$itemData['TOTAL_PRICE'] * 100)
                ->setRequestedDate($itemData['REQUEST_DATE'])
                ->setFulfillment(empty($itemData['FULFILLMENT']) ? 1 : (int)$itemData['FULFILLMENT'])
                ->setPriceAgreement($itemData['SPA_NUMBER'])
                ->setShipment($quoteTransfer->getShipment())
                ->setPurchaseOrderNo($quoteTransfer->getPoNumber())
                ->setPurchaseOrderRef($quoteTransfer->getCustomerPurchaseOrder())
                ->setFiberFee((int)$itemData['laser_engraving_fee'] * 100)
                ->setLaserFee((int)$itemData['long_fiber_fee'] * 100)
                ->setTaxRate(0)
                ->setSumTaxAmount(0)
                ->setImages($this->createImageTransfer($itemData['image']))
                ->setAvalaraTaxCode('P0000000');
            $grandTotal += (int)$itemData['TOTAL_PRICE'];
            $quoteItems->append($itemTransfer);
        }
        $quoteTransfer = $this->overRideTotals($quoteTransfer, $grandTotal);
        $quoteTransfer->setItems($quoteItems);
        $quoteTransfer->setExpenses(new ArrayObject((new ExpenseTransfer())->setSumTaxAmount(0)));

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param int $grandTotal
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function overRideTotals(QuoteTransfer $quoteTransfer, int $grandTotal): QuoteTransfer
    {
        $quoteTransfer->setTotals(
            (new TotalsTransfer())
                ->setGrandTotal($grandTotal)
                ->setSubtotal($grandTotal)
                ->setPriceToPay($grandTotal)
                ->setTaxTotal((new TaxTotalTransfer())
                    ->setTaxRate(0)
                    ->setAmount(0))
                ->setExpenseTotal(0)
                ->setRefundTotal($grandTotal)
                ->setDiscountTotal(0)
                ->setNetTotal($grandTotal)
                ->setShipmentTotal(0)
        );

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    private function mapBillingAddress(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $quoteTransfer->setBillingAddress(
            $this->mapB2bAddressToAddress(
                $quoteTransfer->getQuoteB2bData()->getB2bBillingAddress()
            )
        );
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    private function mapPayment(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $availablePaymentMethods = $this->getFactory()
            ->getPaymentFacade()
            ->getAvailableMethods($quoteTransfer)
            ->getMethods();

        $quotePaymentMethodKey = $quoteTransfer->getQuoteB2bData()
            ->getPaymentMethod()
            ->getPaymentMethodKey();

        $payments = new ArrayObject();
        /** @var \Generated\Shared\Transfer\PaymentMethodTransfer $availablePaymentMethod */
        foreach ($availablePaymentMethods as $availablePaymentMethod) {
            if ($availablePaymentMethod->getPaymentMethodKey() === $quotePaymentMethodKey) {
                $payments->append($this->hydratePaymentTransfer($availablePaymentMethod));
                $quoteTransfer->setPayment($this->hydratePaymentTransfer($availablePaymentMethod));

                break;
            }
        }
        $quoteTransfer->setPayments($payments);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ShipmentTransfer
     */
    private function buildShipmentTransfer(QuoteTransfer $quoteTransfer): ShipmentTransfer
    {
        $shipmentMethodName = $quoteTransfer->getQuoteB2bData()->getShipmentMethodOrFail();
        $carrierName = $quoteTransfer->getQuoteB2bData()->getShipmentCarrierOrFail();

        $shipmentTransfer = (new ShipmentTransfer());
        $shipmentTransfer->setCarrier((new ShipmentCarrierTransfer())->setName($carrierName)->setIsActive(true));
        if ($shipmentMethodName === $this->getFactory()->getRoutingGuideShipmentMethod()) {
            $shipmentTransfer->setCarrier((new ShipmentCarrierTransfer())->setName($this->getFactory()->getRoutingGuideShipmentMethod()));
        }

        $useCarrierName = in_array($shipmentMethodName, $this->getConfig()->getShipmentMethodIncludingCarrier());
        $shipmentMethodKey = $this->prepareShipmentMethodKeyByNameAndCarrier($shipmentMethodName, $carrierName, $useCarrierName);

        $shipmentMethodTransfer = $this->getFactory()->getShipmentFacade()->findShipmentMethodByKey($shipmentMethodKey);
        $shipmentTransfer->setMethod($shipmentMethodTransfer);
        $shipmentTransfer->setShippingAddress($this->mapB2bAddressToAddress($quoteTransfer->getQuoteB2bData()->getB2bShippingAddress()));

        return $shipmentTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\B2bAddressTransfer $b2bAddressTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    private function mapB2bAddressToAddress(B2bAddressTransfer $b2bAddressTransfer): AddressTransfer
    {
        $addressTransfer = new AddressTransfer();
        $addressTransfer->setIsAddressSavingSkipped(true)
            ->setAddress1($b2bAddressTransfer->getStreetAddress1())
            ->setAddress2($b2bAddressTransfer->getStreetAddress2())
            ->setZipCode($b2bAddressTransfer->getZipCode())
            ->setIso2Code($b2bAddressTransfer->getIso2Code())
            ->setRegion($b2bAddressTransfer->getState())
            ->setFkRegion($b2bAddressTransfer->getFkRegion())
            ->setFkCountry($b2bAddressTransfer->getFkCountry())
            ->fromArray($b2bAddressTransfer->toArray(), true);

        if ($addressTransfer->getFkRegion() === null) {
            $spyRegion = $this->getQueryContainer()->getRegionQuery()->filterByName($b2bAddressTransfer->getState())->findOne();
            $addressTransfer->setFkRegion($spyRegion?->getIdRegion());
        }

        return $addressTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentTransfer
     */
    private function hydratePaymentTransfer(PaymentMethodTransfer $paymentMethodTransfer): PaymentTransfer
    {
        return (new PaymentTransfer())
            ->fromArray($paymentMethodTransfer->toArray(), true)
            ->setPaymentSelection($paymentMethodTransfer->getPaymentMethodKey())
            ->setPaymentProvider($paymentMethodTransfer->getPaymentProvider()->getPaymentProviderKey())
            ->setPaymentMethod($paymentMethodTransfer->getPaymentMethodKey());
    }

    /**
     * @param string $shipmentMethodName
     * @param string $shipmentCarrierName
     * @param bool $useCarrierName
     *
     * @return string
     */
    private function prepareShipmentMethodKeyByNameAndCarrier(string $shipmentMethodName, string $shipmentCarrierName, bool $useCarrierName): string
    {
        $shipmentMethodKey = sprintf('%s', strtoupper(str_replace(' ', '_', $shipmentMethodName)));

        if ($useCarrierName) {
            $shipmentMethodKey = $shipmentMethodKey . sprintf('_%s', strtoupper(str_replace(' ', '_', $shipmentCarrierName)));
        }

        return $shipmentMethodKey;
    }

    /**
     * @param string $url
     *
     * @return \ArrayObject
     */
    protected function createImageTransfer(string $url)
    {
        return new ArrayObject([(new ProductImageStorageTransfer())->setExternalUrlSmall($url)]);
    }
}
