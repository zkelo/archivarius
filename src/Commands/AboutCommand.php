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
        $output->writeln('You\'re running an <info>' . $this->getApplication()->getName() . ' ' . $this->getApplication()->getVersion() . '</>');
        $output->writeln('<comment>App that helps you to work with your family photo and video archive.</>');

        $output->writeln(['', '<question>???</> <info>What this app can do?</>']);
        $output->writeln('1. Looking for same photos and videos by hashing each with sha1 algorithm;');
        $output->writeln('2. With 1 step, remove duplicates from your archive (with or without backing it up).');

        $output->writeln(['', '<question>***</>']);
        $output->writeln('Copyright &copy; ' . date('Y') . ' <href=https://zkelo.ru>ZKelo</>');

        return Command::SUCCESS;
    }
}
