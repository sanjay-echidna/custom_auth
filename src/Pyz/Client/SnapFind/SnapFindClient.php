<?php

declare(strict_types = 1);

namespace Pyz\Client\SnapFind;

use Generated\Shared\Transfer\SearchQueryByImageTransfer;
use GuzzleHttp\Exception\GuzzleException;
use Spryker\Client\Kernel\AbstractClient;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Pyz\Client\SnapFind\SnapFindFactory getFactory()
 */
class SnapFindClient extends AbstractClient implements SnapFindClientInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return SearchQueryByImageTransfer
     */
    public function getSearchQueryByImage(UploadedFile $image): SearchQueryByImageTransfer
    {
        $searchQueryByImageTransfer = new SearchQueryByImageTransfer();
        $searchQueryByImageTransfer->setSuccess(false);
        $guzzleClient = $this->getFactory()->createGuzzleClient();
        $base64Image = base64_encode($image->getContent());
        $hash = md5(random_bytes(100));
        $redisKey = 'snap-find:image:' . $hash;
        $this->getFactory()->getStorageRedisClient()->set($redisKey, $base64Image);
        $searchQueryByImageTransfer->setRedisImageKey($redisKey);
        $host = $this->getFactory()->getConfig()->getAiRequestUri();
        try {
            $response = $guzzleClient->post($this->getFactory()->getConfig()->getAiRequestUri(), [
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => 'As e commerce user give the best search string to look for when searching the product given in the image. Only return the search string to enter, no further explanation or any other text.',
                                ],
                                [
                                    'inline_data' => [
                                        'mime_type' => 'image/jpeg',
                                        'data' => $base64Image,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            if ($response->getStatusCode() === Response::HTTP_OK) {
                $responseData = json_decode($response->getBody()->getContents(), true);

                $searchQueryByImageTransfer->setSuccess(true);
                $searchQueryByImageTransfer->setQueryString($responseData['candidates'][0]['content']['parts'][0]['text'] ?? '');
            }

            return $searchQueryByImageTransfer;
        } catch (GuzzleException $guzzleException) {
            return $searchQueryByImageTransfer;
        }
    }
}
