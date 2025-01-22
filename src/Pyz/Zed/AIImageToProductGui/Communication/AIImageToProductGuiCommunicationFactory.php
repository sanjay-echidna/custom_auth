<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AIImageToProductGui\Communication;

use Orm\Zed\Tax\Persistence\SpyTaxSetQuery;
use Pyz\Zed\AIImageToProductGui\AIImageToProductGuiDependencyProvider;
use Pyz\Zed\AIImageToProductGui\Communication\Form\AIProductForm;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Pyz\Zed\AIImageToProductGui\Persistence\AIImageToProductGuiQueryContainer getQueryContainer()
 * @method \Pyz\Zed\AIImageToProductGui\AIImageToProductGuiConfig getConfig()
 * @method \Pyz\Zed\AIImageToProductGui\Business\AIImageToProductGuiFacadeInterface getFacade()
 */
class AIImageToProductGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @param array $formData
     * @param array $formOptions
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createAiProductForm(array $formData = [], array $formOptions = []): FormInterface
    {
        return $this->getFormFactory()->create(AIProductForm::class, $formData, $formOptions);
    }

    public function getImageToTextClient()
    {
        return $this->getProvidedDependency(AIImageToProductGuiDependencyProvider::IMAGE_TO_TEXT_CLIENT);
    }

    /**
     * @return \Orm\Zed\Tax\Persistence\SpyTaxSetQuery
     */
    public function createTaxSetQuery(): SpyTaxSetQuery
    {
        return SpyTaxSetQuery::create();

    }

     /**
     * @return \Spryker\Zed\Product\Persistence\ProductQueryContainerInterface
     */
    public function getProductQueryContainer()
    {
        return $this->getProvidedDependency(AIImageToProductGuiDependencyProvider::QUERY_CONTAINER_PRODUCT);
    }
}
