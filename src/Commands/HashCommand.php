<?php

namespace Zkelo\Archivarius\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\{
    ProgressBar,
    QuestionHelper
};
use Symfony\Component\Console\Input\{
    InputArgument,
    InputInterface
};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Finder\Finder;

/**
 * Makes hash of all files and saves it to file
 */
class HashCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected static $defaultName = 'hash';

    /**
     * {@inheritDoc}
     */
    protected static $defaultDescription = 'Makes hash of all files and saves it to file';

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to search');
        $this->addArgument('filename', InputArgument::OPTIONAL, 'Filename to save', 'hashes_' . date('d.m.Y-H:i:s') . '.csv');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $saveFilename = $input->getArgument('filename');
        $output->writeln('Filename to save: <info>' . $saveFilename . '</>');

        $finder = new Finder;
        $finder->files()->in($input->getArgument('path'));

        if (!$finder->hasResults()) {
            $output->writeln('<error>No files in specified directory</>');
            return Command::INVALID;
        }

        $output->writeln('Counting files in directory and all subderictories...');

        $filesCount = $finder->count();
        $output->writeln('Files count: <info>' . $filesCount . '</>');

        /**
         * @var QuestionHelper $questionHelper
         */
        $questionHelper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Do you really want to continue? <comment>Depending on your PC specs this process can take amount of time (in some cases more than lot of hours)</> ', false);
        if (!$questionHelper->ask($input, $output, $question)) {
            $output->writeln('<error>Cancelled by user</>');
            return Command::SUCCESS;
        }

        $output->writeln('Processing files...');

        $saveFile = fopen(DATA_DIRECTORY . DIRECTORY_SEPARATOR . $saveFilename, 'w');
        fputcsv($saveFile, [
            'filepath',
            'filename',
            'hash'
        ]);

        $progressBar = new ProgressBar($output, $filesCount);

        /* foreach ($finder as $file) {
            $filepath = $file->getRealPath();
            $filename = $file->getRelativePathname();

            $hash = sha1_file($filepath);
            if ($hash === false) {
                $output->writeln("<error>Unable to make hash of \"{$filepath}\" file</>");
            }

            fputcsv($saveFile, [$filepath, $filename, $hash]);
            $progressBar->advance();
        } */

        fclose($saveFile);
        $progressBar->finish();
        return Command::SUCCESS;
    }
}
