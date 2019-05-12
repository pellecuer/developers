<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

class LoadDataCommand extends Command
{
    protected static $defaultName = 'loadData';

    public function __construct(EntityManagerInterface $em)
    {        
        parent::__construct();
        $this->em = $em;
    }
    
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

        //début du code

        $connexion = $this->em
        ->getConnection();
        
        if (!$connexion) {
            echo "couldn't connect to database";
            exit;
        } else {
            $sql ="LOAD DATA INFILE '/var/lib/mysql-files/developers_big.csv'
            INTO TABLE import
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES 
            (last_name, first_name, badge_label, badge_level)";

            if ($connexion->query($sql)) {
                echo ("executed");
            } else {
                echo ("error");
            }
        }

        //fin du code


    }
}
