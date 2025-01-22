<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\CustomAuth\Provider;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Yves\Kernel\AbstractPlugin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * @method \Pyz\Yves\CustomAuth\CustomAuthFactory getFactory()
 */
class CustomAuthenticationSuccessHandler extends AbstractPlugin implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var string
     */
    public const MESSAGE_CUSTOMER_AUTHENTICATION_FAILED = 'customer.authentication.failed';

    /**
     * @see HomePageRouteProviderPlugin::ROUTE_HOME
     *
     * @var string
     */
    protected const ROUTE_HOME = '/en/customer/overview';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        /** @var \SprykerShop\Yves\CustomerPage\Security\Customer $customer */
        $customer = $token->getUser();
        $this->setCustomerSession($customer->getCustomerTransfer());
        $this->getFactory()->getTokenStorage()->setToken($token);
        $response = $this->createRedirectResponse($request);

        $this->executeAfterPlugins();

        $this->getFactory()->createAuditLogger()->addSuccessfulLoginAuditLog();

        return $response;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    protected function setCustomerSession(CustomerTransfer $customerTransfer)
    {
        $this->getFactory()
            ->getCustomerClient()
            ->setCustomer($customerTransfer);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function createRedirectResponse(Request $request)
    {
        $targetUrl = $this->determineTargetUrl($request);

        $response = $this->getFactory() ->createRedirectResponse($targetUrl);

        return $response;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string
     */
    protected function determineTargetUrl($request)
    {
        if ($request->headers->has('Referer')) {
            return (string)$request->headers->get('Referer');
        }

        return static::ROUTE_HOME;
    }

    /**
     * @return void
     */
    protected function executeAfterPlugins(): void
    {
        $afterCustomerAuthenticationSuccessPlugins = $this->getFactory()->getAfterCustomerAuthenticationSuccessPlugins();

        foreach ($afterCustomerAuthenticationSuccessPlugins as $afterCustomerAuthenticationSuccessPlugin) {
            $afterCustomerAuthenticationSuccessPlugin->execute();
        }
    }
}


