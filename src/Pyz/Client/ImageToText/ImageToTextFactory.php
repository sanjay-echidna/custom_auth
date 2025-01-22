<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ImageToText;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Spryker\Client\Kernel\AbstractFactory;

/**
 * @method \Pyz\Client\ImageToText\ImageToTextConfig getConfig()
 */
class ImageToTextFactory extends AbstractFactory
{
    private $client;

    public function createGuzzleClient(): GuzzleClientInterface
    {
        if (!$this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }

    public function getFullApiEndpoint()
    {
        $config = $this->getConfig();

        return $config->getHost() . '?key=' . $config->getApiKey();
    }
}
