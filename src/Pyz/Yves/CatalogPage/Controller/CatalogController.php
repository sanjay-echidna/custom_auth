<?php

namespace Pyz\Yves\CatalogPage\Controller;

use Pyz\Yves\CatalogPage\CatalogPageFactory;
use SprykerShop\Yves\CatalogPage\Controller\CatalogController as SprykerCatalogController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method CatalogPageFactory getFactory()
 */
class CatalogController extends SprykerCatalogController
{
    /**
     * @param Request $request
     * @return array|mixed[]
     */
    protected function executeFulltextSearchAction(Request $request): array
    {
        $viewData = parent::executeFulltextSearchAction($request);
        $viewData['image'] = null;

        if (!empty($request->query->get('imageHash'))) {
            $imageHash = $request->query->get('imageHash');
            $image = $this->getFactory()->getStorageRedisClient()->get($imageHash);
            $viewData['image'] = $image;
        }

        return $viewData;
    }


}
