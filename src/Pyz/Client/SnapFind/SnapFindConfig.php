<?php

declare(strict_types = 1);

namespace Pyz\Client\SnapFind;

use Pyz\Shared\SnapFind\SnapFindConstants;
use Spryker\Client\Kernel\AbstractBundleConfig;

class SnapFindConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getAiRequestUri(): string
    {
        return $this->get(SnapFindConstants::GEMINI_HOST_ENDPOINT) . '?key=' . $this->get(SnapFindConstants::GEMINI_API_KEY);
    }
}
