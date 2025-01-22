<?php
namespace Pyz\Service\Sentry;

use Spryker\Service\Kernel\AbstractService;
use TurbineKreuzberg\Service\Sentry\SentryService as SprykerSentryService;

class SentryService extends SprykerSentryService
{
    /**
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function setTag(string $key, string $value): void
    {
        $this->getFactory()->createSentryGateway()->setTag($key, $value);
    }

    /**
     * @return void
     */
    public function finishCurrentTransaction(): void
    {
        $this->getFactory()->createSentryGateway()->finishCurrentTransaction();
    }


    /**
     * @param string $name
     * @param array $context
     *
     * @return void
     */
    public function setContext(string $name, array $context): void
    {
        $this->getFactory()->createSentryGateway()->setContext($name, $context);
    }

}
