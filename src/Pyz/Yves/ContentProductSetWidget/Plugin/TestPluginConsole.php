<?php
namespace Pyz\Yves\ContentProductSetWidget\Plugin;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestPluginConsole extends Command
{
    protected static $defaultName = 'code:sniff:test';

    protected function configure(): void
    {
        $this
            ->setDescription('Sniff and fix twig code style')
            ->setHelp('This command allows you to sniff and fix Twig code style issues...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Running Twig Code Sniffer...');
        // Add your logic here

        return Command::SUCCESS;
    }
}
