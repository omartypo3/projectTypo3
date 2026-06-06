<?php

namespace NITSAN\NsRevolutionSlider\Slots;

use Doctrine\DBAL\Exception\TableNotFoundException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Setup
 */
class SetupUtility extends Command
{
    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setHelp('EXT: ns_revolution_slider installation');
    }

    /**
     * Executes the command for ns_revolution_slider
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());
        $dbConnection = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $dbConnection->getQueryBuilderForTable('wp_options');
        $tableNotExist = false;
        $rows = [];
        try {
            $rows = $queryBuilder
                ->select('*')
                ->from('wp_options')
                ->execute()
                ->fetchAll();
        } catch (TableNotFoundException $e) {
            $tableNotExist = true;
        }
        if (count($rows) === 0 && $tableNotExist) {
            $installUtility = GeneralUtility::makeInstance(\NITSAN\NsRevolutionSlider\Slots\InstallUtility::class);
            $installUtility->updateDatabase();
            $io->success('TYPO3 slider revolution successfully installed!');
        } else {
            $io->success('TYPO3 slider revolution already installed!');
        }
        return Command::SUCCESS;
    }
}
