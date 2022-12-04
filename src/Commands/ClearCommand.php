<?php

namespace Zkelo\Archivarius\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Clears data directory
 */
class ClearCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected static $defaultName = 'clear';

    /**
     * {@inheritDoc}
     */
    protected static $defaultDescription = 'Clears data directory';

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder;
        $finder->files()->in(DATA_DIRECTORY)->exclude('gitignore');

        $filesystem = new Filesystem;
        $filesystem->remove($finder);

        return Command::SUCCESS;
    }
}
