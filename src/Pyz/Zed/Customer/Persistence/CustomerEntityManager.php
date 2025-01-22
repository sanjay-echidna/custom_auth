<?php

namespace Pyz\Zed\Customer\Persistence;

use Generated\Shared\Transfer\SsoTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Customer\Persistence\CustomerEntityManager as PersistenceCustomerEntityManager;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;


class CustomerEntityManager extends PersistenceCustomerEntityManager implements CustomerEntityManagerInterface
{
    /**
     *
     * @param \Generated\Shared\Transfer\SsoTransfer $ssoTransfer
     * @return \Generated\Shared\Transfer\SsoTransfer
     */
    public function validateSsoToken(SsoTransfer $ssoTransfer): SsoTransfer
    {
        $token = $ssoTransfer->getToken();
        if (!$token) {
            $ssoTransfer->setIsValid(false);
            $ssoTransfer->setMessage('No Token is found');
            return $ssoTransfer;
        }

        $customerEntities = SpyCustomerQuery::create()->find();

        foreach ($customerEntities as $customerEntity) {
            $email = $customerEntity->getEmail();
            $hashedEmail = hash('sha256', $email);

            if ($hashedEmail === $token) {
                $ssoTransfer->setIsValid(true);
                $ssoTransfer->setMessage('Token is valid.');
                return $ssoTransfer;
            }
        }

        $ssoTransfer->setIsValid(false);
        $ssoTransfer->setMessage('Invalid token.');
        return $ssoTransfer;
    }
}
