<?php

namespace App\Command;

use Doctrine\Common\Persistence\ObjectManager;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportMoneyWizRecords extends Command
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:import-money-wiz-records')
            ->addArgument('csv', InputArgument::REQUIRED, 'The Path Of The MoneyWiz Record CSV File.')
            ->setDescription('Import MoneyWiz Records.')
            ->setHelp('This command allows you to import MoneyWiz Records.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '2048M');

        $dateFormat = 'Y-m-d H:i:s';

        $io = new SymfonyStyle($input, $output);
        $csvPath = $input->getArgument('csv');

        $io->title($this->getName());
        $io->writeln('Start at ' . date($dateFormat));

        if (!file_exists($csvPath)) {
            $io->error("$csvPath does not exist.");
            return;
        }

        $this->import($this->objectManager, $io, $csvPath);

        $io->writeln('End at ' . date($dateFormat));
    }

    private function import(ObjectManager $em, SymfonyStyle $io, string $csvPath)
    {

        $csv = Reader::createFromPath($csvPath, 'r');

        $totalCount = 0;

        foreach ($csv as $index => $data) {
            if ($index === 0) {
                continue;
            }

            dump($data[4]);
            ++$totalCount;
        }

        $io->writeln("$totalCount");
    }

}