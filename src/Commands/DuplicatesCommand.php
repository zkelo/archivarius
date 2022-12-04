<?php

namespace Zkelo\Archivarius\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{
    InputArgument,
    InputInterface,
    InputOption
};
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Finds duplicates in CSV by hash
 */
class DuplicatesCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected static $defaultName = 'duplicates';

    /**
     * {@inheritDoc}
     */
    protected static $defaultDescription = 'Finds duplicates in CSV by hash';

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'Path');

        $this->addOption('filepath_column', 'fpcol', InputOption::VALUE_OPTIONAL, 'Filepath column name', 'filepath');
        $this->addOption('hash_column', 'hcol', InputOption::VALUE_OPTIONAL, 'Hash column name', 'hash');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filepath = $input->getArgument('path');
        if (empty($filepath)) {
            $output->writeln('<error>You need to specify filepath to CSV file with hashes</>');
            return Command::FAILURE;
        }

        // TODO Make this command work
        return Command::SUCCESS;
    }
}
