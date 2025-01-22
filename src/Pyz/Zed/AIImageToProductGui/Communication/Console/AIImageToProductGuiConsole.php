<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AIImageToProductGui\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Pyz\Zed\AIImageToProductGui\Business\AIImageToProductGuiFacadeInterface getFacade()
 * @method \Pyz\Zed\AIImageToProductGui\Communication\AIImageToProductGuiCommunicationFactory getFactory()
 */
class AIImageToProductGuiConsole extends Console
{
 /**
  * @var string
  */
    public const COMMAND_NAME = 'some:command';

    /**
     * @var string
     */
    public const DESCRIPTION = 'Describe me!';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $messenger = $this->getMessenger();

        $messenger->info(sprintf(
            'You just executed %s!',
            static::COMMAND_NAME,
        ));

        return static::CODE_SUCCESS;
    }
}
