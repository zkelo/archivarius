<?php

namespace Zkelo\Archivarius\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Displays information about application
 */
class AboutCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected static $defaultName = 'about';

    /**
     * {@inheritDoc}
     */
    protected static $defaultDescription = 'Displays information about application';

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setHelp('This commands displays information about application');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('You\'re running an ' . $this->getApplication()->getName() . ' ' . $this->getApplication()->getVersion());
        $output->writeln('App that helps you to work with your family photo and video archive.');
        return Command::SUCCESS;
    }
}
