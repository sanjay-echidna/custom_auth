<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ImageToText;

interface ImageToTextClientInterface
{
    /**
     * Summary of getName and Description By image Url
     *
     * @param string $url
     *
     * @return array
     */
    public function getNameDescriptionByUrl(string $url): array;
}
