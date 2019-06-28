<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use App\Entity\Country;
use App\Entity\Genre;
use App\Entity\Language;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InsertDefaultDataCommand extends Command
{
    protected static $defaultName = 'app:insert-default-data';

    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Insert default data into app')
        ;
    }

    private function getData(): array
    {
        return [
            'Country' => [
                [
                    'Code' => 'US',
                    'Nationality' => 'American',
                ],
            ],
            'Genre' => [
                [
                    'Name' => 'Comedy',
                ],
                [
                    'Name' => 'Action',
                ],
            ],
            'Language' => [
                [
                    'Name' => 'EN',
                ],
            ],
            'AwardCategory' => [
                [
                    'Name' => 'Best Achievement in Sound Editing',
                ],
                [
                    'Name' => 'Best Achievement in Visual Effects',
                ],
            ],
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $dataToInsert = $this->getData();
        $progressBar = new ProgressBar($output, count($dataToInsert));
        $entityManager = $this->container->get('doctrine')->getManager();

        foreach ($dataToInsert as $className => $data) {
            foreach ($data as $row) {
                try {
                    $fullNameClass = 'App\Entity\\' . $className;
                    $entity = new $fullNameClass();

                    foreach ($row as $column => $value) {
                        $function = 'set' . $column;
                        $entity->$function($value);
                    }

                    $entityManager->persist($entity);
                } catch (\Exception $e) {
                    
                }
            }

            $progressBar->advance();
        }

        $entityManager->flush();

        $progressBar->finish();
        $io->success('Data inserted with successful.');
    }
}
