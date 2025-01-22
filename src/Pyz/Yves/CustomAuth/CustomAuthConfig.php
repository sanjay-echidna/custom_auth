<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CustomAuth;

use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Yves\Customer\CustomerConfig;

class CustomAuthConfig extends CustomerConfig
{

    /**
     * @api
     *
     * @return string
     */
    public function getAnonymousPattern(): string
    {
        return $this->get(CustomerConstants::CUSTOMER_ANONYMOUS_PATTERN);
    }

}
