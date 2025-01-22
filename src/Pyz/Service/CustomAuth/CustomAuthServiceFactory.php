<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\CustomAuth;

use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validator;
use Spryker\Service\Kernel\AbstractServiceFactory;

/**
 * @method \Pyz\Service\CustomAuth\CustomAuthConfig getConfig()
 */
class CustomAuthServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \Lcobucci\JWT\Validator
     */
    public function getJwtValidator(): Validator
    {
        return $this->getConfiguration()->validator();
    }

    /**
     * @return \Lcobucci\JWT\Configuration
     */
    protected function getConfiguration(): Configuration
    {
        $configuration = Configuration::forSymmetricSigner($this->createSigner(), $this->getKey());
        $configuration->setValidationConstraints(
            $this->createValidAtConstraint(),
            $this->createSignedWithConstraint()
        );

        return $configuration;
    }

    /**
     * @return \Lcobucci\JWT\Signer\Hmac\Sha256
     */
    protected function createSigner(): Signer
    {
        return new Sha256();
    }

    /**
     * @return \Lcobucci\JWT\Signer\Key\InMemory
     */
    protected function getKey(): Key
    {
        return InMemory::plainText($this->getConfig()->getCustomAuthSecret());
    }

    /**
     * @return \Lcobucci\JWT\Validation\Constraint\LooseValidAt
     */
    public function createValidAtConstraint(): LooseValidAt
    {
        return new LooseValidAt($this->getSystemClock());
    }

    /**
     * @return \Lcobucci\Clock\SystemClock
     */
    protected function getSystemClock(): SystemClock
    {
        return SystemClock::fromSystemTimezone();
    }

    /**
     * @return \Lcobucci\JWT\Validation\Constraint
     */
    public function createSignedWithConstraint(): Constraint
    {
        return new SignedWith($this->createSigner(), $this->getKey());
    }

    /**
     * @return \Lcobucci\JWT\Parser
     */
    public function getJwtParser(): Parser
    {
        return $this->getConfiguration()->parser();
    }
}
