<?php

namespace App\Command;

use App\Entity\Record;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportMoneyWizRecords extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:import-money-wiz-records')
            ->setDescription('Import MoneyWiz Records.')
            ->setHelp('This command allows you to import MoneyWiz Records.')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('empty-existing-data'),
                    new InputOption('dummy-import'),
                    new InputOption('csv', null, InputOption::VALUE_REQUIRED)
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '2048M');

        $dateFormat = 'Y-m-d H:i:s';

        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('empty-existing-data')) {
            $connection = $this->entityManager->getConnection();
            $platform = $connection->getDatabasePlatform();

            $connection->executeUpdate($platform->getTruncateTableSQL('record', true));
        }

        $csvPath = $input->getOption('csv');

        $io->title($this->getName());
        $startTime = new \DateTime();

        $io->writeln('Start at ' . date($dateFormat, $startTime->getTimestamp()));

        if (!file_exists($csvPath)) {
            $io->error("$csvPath does not exist.");
            return;
        }

        $this->import($this->entityManager, $io, $csvPath, $input->getOption('dummy-import'));

        $endTime = new \DateTime();
        $io->writeln('End at ' . date($dateFormat, $endTime->getTimestamp()));
        $io->writeln('Spend Time: ' . $endTime->diff($startTime)->format('%ss'));
    }

    private function import(EntityManagerInterface $em, SymfonyStyle $io, string $csvPath, bool $isDummyImport)
    {

        $csv = Reader::createFromPath($csvPath, 'r');

        $totalCount = 0;
        $batchSize = 500;

        foreach ($csv as $index => $data) {
            if ($index === 0) {
                continue;
            }

            $account = $data[1];
            $description = $data[4];
            $category = $data[5];
            $datetime = \DateTime::createFromFormat('Y/m/d H:i', $data[6] . ' ' . $data[7]);
            $amount = floatval(preg_replace('/[^-0-9\.]/', '', $data[9]));;
            $currency = $data[10];
            $tags = $data[12];

            $record = new Record();
            $record->setAccount($account);
            $record->setDescription($description);
            $record->setCategory($category);
            $record->setDatetime($datetime ? $datetime : (new \DateTime()));
            $record->setAmount($amount);
            $record->setCurrency($currency);
            $record->setTags($tags);
            if ($record->getDescription()) {
                $em->persist($record);
                $io->writeln("Import: {$record->getDetail()}");
                ++$totalCount;
            }

            if (0 == ($totalCount % $batchSize) && !$isDummyImport) {
                $em->flush();
            }
        }

        if (!$isDummyImport) {
            $em->flush();
        }

        $io->writeln("Import {$totalCount} Records");
    }

}