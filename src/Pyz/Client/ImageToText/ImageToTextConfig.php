<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\ImageToText;

use Pyz\Shared\ImageToText\ImageToTextConstants;
use Spryker\Client\Kernel\AbstractBundleConfig;

class ImageToTextConfig extends AbstractBundleConfig
{
    public function getHost(): string
    {
        return $this->get(ImageToTextConstants::GEMINI_HOST_ENDPOINT);
    }

    public function getApiKey(): string
    {
        return $this->get(ImageToTextConstants::GEMINI_API_KEY);
    }
}
