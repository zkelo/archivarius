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
     * Filename column name option
     */
    const OPTION_FILEPATH_COLUMN = 'filepath_column';

    /**
     * Hash column name option
     */
    const OPTION_HASH_COLUMN = 'hash';

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

        $this->addOption(static::OPTION_FILEPATH_COLUMN, 'fpcol', InputOption::VALUE_OPTIONAL, 'Filepath column name', 'filepath');
        $this->addOption(static::OPTION_HASH_COLUMN, 'hcol', InputOption::VALUE_OPTIONAL, 'Hash column name', 'hash');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filepath = $input->getArgument('path');
        if (!file_exists($filepath)) {
            $output->writeln('<error>You need to specify filepath to CSV file with hashes</>');
            return Command::INVALID;
        }

        $files = [
            fopen($filepath, 'r'),
            fopen($filepath, 'r')
        ];

        $filepathColumnName = $input->getOption(static::OPTION_FILEPATH_COLUMN);
        $hashColumnName = $input->getOption(static::OPTION_HASH_COLUMN);

        $headers = [];
        $first = [
            true,
            true
        ];

        while ($fRow = fgetcsv($files[0])) {
            if ($first[0]) {
                $filepathColumn = array_search($filepathColumnName, $fRow);
                if ($filepathColumn === false) {
                    $output->writeln("<error>Unable to find \"{$filepathColumnName}\" in input CSV</>");
                    return Command::INVALID;
                }

                $hashColumn = array_search($hashColumnName, $fRow);
                if ($hashColumn === false) {
                    $output->writeln("<error>Unable to find \"{$hashColumnName}\" in input CSV</>");
                    return Command::INVALID;
                }

                $headers[$filepathColumnName] = $filepathColumn;
                $headers[$hashColumnName] = $hashColumn;

                $first[0] = false;
                continue;
            }

            $fpath = $fRow[$headers[$filepathColumnName]];
            $hash = $fRow[$headers[$hashColumnName]];

            // TODO
        }

        foreach ($files as $file) {
            fclose($file);
        }

        return Command::SUCCESS;
    }
}
