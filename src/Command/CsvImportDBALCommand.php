<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;


class CsvImportDBALCommand extends Command
{
    public function __construct(EntityManagerInterface $em)
    {
        
        parent::__construct();

        $this->em = $em;
    }

    protected static $defaultName = 'bigImport';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $connexion = $this->em
        ->getConnection(); 
                
        $sql = "INSERT INTO developer (id, first_name, last_name) VALUES 
        (NULL, 'zzzz', 'zzzz'),        
        ;";        
        
        $connexion->query($sql);
        $io->success('Importation effectuée avec succès.');
    }
}
