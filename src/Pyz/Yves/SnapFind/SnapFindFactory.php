<?php

declare(strict_types = 1);

namespace Pyz\Yves\SnapFind;

use Pyz\Yves\SnapFind\Form\FormFactory;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @method \Pyz\Yves\SnapFind\SnapFindConfig getConfig()
 */
class SnapFindFactory extends AbstractFactory
{
    /**
     * @return FormFactory
     */
    public function createSnapFindFormFactory(): FormFactory
    {
        return new FormFactory();
    }
}
