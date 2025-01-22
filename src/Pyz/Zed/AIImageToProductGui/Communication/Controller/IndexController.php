<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AIImageToProductGui\Communication\Controller;

use ArrayObject;
use Generated\Shared\Transfer\LocalizedAttributesTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductImageSetTransfer;
use Generated\Shared\Transfer\ProductImageTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Spryker\Zed\Locale\Business\LocaleFacade;
use Spryker\Zed\Product\Business\ProductFacade;
use Spryker\Zed\Store\Business\StoreFacade;
use Spryker\Zed\Tax\Business\TaxFacade;
use Symfony\Component\HttpFoundation\Request;


/**
 * @method \Pyz\Zed\AIImageToProductGui\Business\AIImageToProductGuiFacadeInterface getFacade()
 * @method \Pyz\Zed\AIImageToProductGui\Communication\AIImageToProductGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\AIImageToProductGui\Persistence\AIImageToProductGuiQueryContainer getQueryContainer()
 */
class IndexController extends AbstractController
{
    /**
     * Summary of index Action
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request)
    {
        $form = $this
            ->getFactory()
            ->createAiProductForm()
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sku = $form->get('sku')->getData();
            $fileUrl = $form->get('image')->getData();
            $taxId = $form->get('tax_rate')->getData();
            $imgTextClient = $this->getFactory()->getImageToTextClient();
            $dataSet = $imgTextClient->getNameDescriptionByUrl($fileUrl);

            try {
                $productAbstractTransfer = new ProductAbstractTransfer();
                $productAbstractTransfer->setSku($sku);
                $productAbstractTransfer->setName($dataSet['title']);
                $productAbstractTransfer->setIdTaxSet($taxId);
                $storeRelationTransfer = new StoreRelationTransfer();
                $storeFacade = new StoreFacade();
                //$storeFacade->getCurrentStore()->getIdStore()
                $storeRelationTransfer->setIdStores([1]);
                $productAbstractTransfer->setStoreRelation($storeRelationTransfer);

                $productImageTransfer = (new ProductImageTransfer())
                    ->setExternalUrlSmall($fileUrl)
                    ->setExternalUrlLarge($fileUrl);

                $productImageSetTransfers = new ArrayObject(); // no existing set for new products
                $productImageSetTransfer = (new ProductImageSetTransfer())
                    ->setName('main')
                    // ->setIdProductAbstract($this->productAbstractEntity->getIdProductAbstract())
                    ->addProductImage($productImageTransfer);

                $productImageSetTransfers->append($productImageSetTransfer);
                $productAbstractTransfer->setImageSets($productImageSetTransfers);

                $localizedAttributes = new ArrayObject();
                $localizedAttributesTransfer = new LocalizedAttributesTransfer();
                $localeFacade = new LocaleFacade();
                $localizedAttributesTransfer->setLocale($localeFacade->getCurrentLocale());
                $localizedAttributesTransfer->setName($dataSet['title']);
                $localizedAttributesTransfer->setDescription($dataSet['description']);
                $localizedAttributesTransfer->setMetaTitle($dataSet['seo_title'] ?? '');
                $localizedAttributesTransfer->setMetaDescription($dataSet['seo_description'] ?? '');
                $localizedAttributesTransfer->setMetaKeywords($dataSet['seo_keywords'] ?? '');

                $localizedAttributes->append($localizedAttributesTransfer);
                $productAbstractTransfer->setLocalizedAttributes($localizedAttributes);
                $productFacade = new ProductFacade();
                $concreteProductCollection = $this->createProductConcreteCollection($productAbstractTransfer);
                $idAbstractProduct = $productFacade->addProduct(
                    $productAbstractTransfer,
                    $concreteProductCollection,
                );
                // $productConcreteTransferArray = $productFacade->getConcreteProductsByAbstractProductId($idAbstractProduct);
                // $this->activateConcreteProduct($productConcreteTransferArray, $productFacade);
                $idProductAbstract = $productAbstractTransfer->getIdProductAbstract();

                return $this->redirectResponse(
                    Url::generate('/product-management/edit', [
                        'id-product-abstract' => $idProductAbstract,
                    ])->build(),
                );
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        return $this->viewResponse([
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected function copyProductAbstractToProductConcrete(ProductAbstractTransfer $productAbstractTransfer): ProductConcreteTransfer
    {
        $productConcreteTransfer = (new ProductConcreteTransfer())
            ->setSku($productAbstractTransfer->getSku())
            ->setIsActive(true)
            ->setLocalizedAttributes($productAbstractTransfer->getLocalizedAttributes());
        foreach ($productAbstractTransfer->getPrices() as $price) {
            $productConcreteTransfer->addPrice(clone $price);
        }

        return $productConcreteTransfer;
    }

    /**
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    protected function createProductConcreteCollection($productAbstractTransfer): array
    {
        $productFacade = new ProductFacade();
        $concreteProductCollection = $productFacade->generateVariants($productAbstractTransfer, []);
        if (!$concreteProductCollection) {
            $concreteProductCollection = $this->copyProductAbstractToProductConcrete($productAbstractTransfer);

            return [$concreteProductCollection];
        }

        return $concreteProductCollection;
    }

    /**
     * @return int
     */
    protected function getTaxSetIdByName(string $taxSetName): int
    {
        $taxFacade = new TaxFacade();
        $taxSetCollection = $taxFacade->getTaxSets();
        $taxSetId = 0;
        foreach ($taxSetCollection->getTaxSets() as $taxSet) {
            if ($taxSet->getName() == $taxSetName) {
                $taxSetId = $taxSet->getIdTaxSet();
            }
        }

        return $taxSetId;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     * @param \Spryker\Zed\Product\Business\ProductFacade
     *
     * @return void
     */
    protected function activateConcreteProduct($productConcreteTransferArray, ProductFacade $productFacade): void
    {
        foreach ($productConcreteTransferArray as $productConcreteTransfer) {
            $productFacade->activateProductConcrete($productConcreteTransfer->getIdProductConcrete());
        }
    }
}
