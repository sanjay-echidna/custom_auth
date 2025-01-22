<?php
namespace Pyz\Yves\CustomAuth\Controller;

use Generated\Shared\Transfer\SsoTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Pyz\Client\CustomAuth\CustomAuthClientInterface getClient()
 * @method \Pyz\Yves\CustomerPage\CustomerPageFactory getFactory()
 */
class SSOController extends AbstractController
{
    /**
     * Handles the SSO login process.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $token
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ssoAction(Request $request, string $token): Response
    {   
        // if(!$this->isLoggedInCustomer()) {
        //     return new Response('Customer is not logged in.', Response::HTTP_UNAUTHORIZED);
        // }
        
        $ssoTransfer =  new SsoTransfer();
        $ssoTransfer->setToken($token);

        if (!$this->isValidToken($ssoTransfer)) {
            // return new Response('Invalid token.', Response::HTTP_UNAUTHORIZED);
        } else {
            // return new Response('Authenticated.', Response::HTTP_OK);
        }

        
        //$this->loginCustomer($customer);

        // Redirect to the home page or desired location
        //return $this->redirect('/');
    }

    /**
     * @return bool
     */
    protected function isLoggedInCustomer()
    {
        return $this->getFactory()->getCustomerClient()->isLoggedIn();
    }

    /**
     *
     * @param SsoTransfer $token
     * @return bool
     */
    protected function isValidToken(SsoTransfer $token): bool
    {
        return false;
        // Validate the token using the client
        $ssoTransfer = $this->getClient()->validateSsoToken($token);
        return $ssoTransfer->getIsValid();
    }
}
