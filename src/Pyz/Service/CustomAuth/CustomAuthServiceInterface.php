<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\CustomAuth;


interface CustomAuthServiceInterface
{
    /**
     * Decrypts a token.
     *
     * @param string $token
     * @return string|null
     */
    public function decryptToken(string $token): ?string;

    /**
     * Encrypts data into a token.
     *
     * @param string $data
     * @return string
     */
    public function encryptToken(string $data): string;
}
