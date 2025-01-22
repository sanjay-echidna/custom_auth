<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

 namespace Pyz\Yves\CustomAuth\Provider;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

/**
 * @method \Spryker\Client\Customer\CustomerClientInterface getClient()
 * @method \SprykerShop\Yves\CustomerPage\CustomerPageFactory getFactory()
 */
class CustomAuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    /**
     * @var string
     */
    public const MESSAGE_CUSTOMER_AUTHENTICATION_FAILED = 'customer.authentication.failed';

    /**
     * @var string|null
     */
    protected $targetUrl;

    /**
     * @param string|null $targetUrl
     */
    public function __construct(?string $targetUrl = null)
    {
        $this->targetUrl = $targetUrl;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        dd($exception);
        $this->getFactory()->createAuditLogger()->addFailedLoginAuditLog();

        return $this->getFactory()->createRedirectResponse($request, $this->targetUrl);
    }
}
