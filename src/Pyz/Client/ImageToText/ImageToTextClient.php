<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\ImageToText;

use Exception;
use Spryker\Client\Kernel\AbstractClient;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Pyz\Client\ImageToText\ImageToTextFactory getFactory()
 */
class ImageToTextClient extends AbstractClient implements ImageToTextClientInterface
{
    /**
     * Summary of getName and Description By image Url
     *
     * @param string $url
     *
     * @return array
     */
    public function getNameDescriptionByUrl(string $url): array
    {
        $guzzleClient = $this->getFactory()->createGuzzleClient();
        $uri = $this->getFactory()->getFullApiEndpoint();

        try {
            $data = file_get_contents($url);
            if ($data) {
                $base64 = base64_encode($data);

                $response = $guzzleClient->post($uri, [
                    'json' => [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => 'As ecommerce domain expert, provide title, description, seo_title, seo_keywords, seo_description for given image in json format. DO NOT INCLUDE BACKTICKS IN THE RESPONSE',
                                    ],
                                    [
                                        'inline_data' => [
                                            'mime_type' => 'image/jpeg',
                                            'data' => $base64,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]);

                if ($response->getStatusCode() === Response::HTTP_OK) {
                    $jsonResponse = json_decode($response->getBody()->getContents(), true);
                    $firstAnswer = $jsonResponse['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    $firstAnswerArray = json_decode($firstAnswer, true);

                    return $firstAnswerArray;
                }
            }

            return [];
        } catch (Exception $e) {
            return [];
        }
    }
}
