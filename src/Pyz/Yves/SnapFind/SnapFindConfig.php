<?php

declare(strict_types = 1);

namespace Pyz\Yves\SnapFind;

use Spryker\Yves\Kernel\AbstractBundleConfig;
use Pyz\Shared\SnapFind\SnapFindConstants;

class SnapFindConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getTestConfigValue(): array
    {
        return $this->get(SnapFindConstants::EXAMPLE_QUEUE_CHUNK_SIZE, []);
    }
}
