<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\CustomAuth;

use Spryker\Service\Kernel\AbstractService;

/**
 * @method \Pyz\Service\CustomAuth\CustomAuthServiceFactory getFactory()
 */
class CustomAuthService extends AbstractService
{
    private const METHOD = "AES-256-CBC";
    private const KEY = "encryptionKey123encryptionKey123";
    private const OPTIONS = 0;
    private const IV = '1234567891011121';

    /**
     * Decrypts a token.
     *
     * @param string $token
     * @return string|null
     */
    public function decryptToken(string $token): ?string
    {
        $token = base64_encode(hex2bin($token));
        return openssl_decrypt($token, self::METHOD, self::KEY, self::OPTIONS, self::IV);
    }

    /**
     * Encrypts data into a token.
     *
     * @param string $data
     * @return string
     */
    public function encryptToken(string $data): string
    {
        return openssl_encrypt($data, self::METHOD, self::KEY, self::OPTIONS, self::IV);
    }
}
