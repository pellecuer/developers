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
use League\Csv\Reader;


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
        $io->title('Importation en cours');

        $connexion = $this->em
        ->getConnection();
        
        $reader = Reader::createFromPath('%kernel.root_dir%/../src/Data/developers_big.csv')
        ->setHeaderOffset(0);
        $results = $reader->getrecords(); 
        $io->progressStart(iterator_count($results));
        
        $sql = "INSERT INTO developer (id, first_name, last_name) VALUES";
        foreach ($results as $row) {
            $firstName = $row['FIRSTNAME'];
            $lastName = $row['LASTNAME'];
            $sql = "$sql" . "(NULL, '" . $firstName . "', '" . $lastName . "'),";
            $io->progressAdvance();
        }

        $stmt = $connexion->prepare($sql);
        
        // $stmt->query($sql);
        $stmt->execute($sql);
        

        // foreach ($results as $row) {
        // $connexion->insert('developer', array(
        //     'first_name' => $row['FIRSTNAME'],
        //     'last_name' => $row['LASTNAME']
        //     ));
        // $io->progressAdvance();
        }
       
       
        

        
        //$connexion->query($sql);
        $io->progressFinish();       
        $io->success('Importation effectuée avec succès.');
    }
}
