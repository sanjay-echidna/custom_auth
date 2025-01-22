<?php

declare(strict_types = 1);

namespace Pyz\Yves\SnapFind\Widget;

use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \Pyz\Yves\SnapFind\SnapFindConfig getConfig()
 */
class SnapFindWidget extends AbstractWidget
{
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'SnapFind';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@SnapFind/views/shop-ui/widget-view.twig';
    }
}
