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

        
        $connexion = $this->em
        ->getConnection();

        //$bdd = new PDO('mysql:host=127.0.0.1; dbname=developers','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_LOCAL_INFILE => true));
        
        if (!$connexion) {
            echo "couldn't connect to database";
            exit;
        } else {            
            $sql1 ="CREATE TABLE IF NOT EXISTS import ( last_name  VARCHAR(255) NOT NULL , first_name VARCHAR(255) NOT NULL , badge_label VARCHAR(255) NOT NULL , badge_level VARCHAR(255) NOT NULL )";
            $stmt = $connexion->prepare($sql1);
            $stmt->execute();

            $p = "../data/Data/developers_big.csv";
            $p = addslashes($p);

            
            $sql2 = "TRUNCATE TABLE import;";
            $stmt = $connexion->prepare($sql2);
            $stmt->execute();
            
            
            $sql3 = "LOAD DATA INFILE '$p'
            INTO TABLE import FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (last_name, first_name, badge_label, badge_level)
            ;";
            $stmt = $connexion->prepare($sql3);
            $stmt->execute();
            

            if ($connexion->query($sql3)) {
                echo ("executed");
            } else {
                echo ("error");
            }
        }
    }
}
