<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Developer;
use App\Entity\BadgeLabel;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;

class CsvImportCommand extends Command
{
    public function __construct(EntityManagerInterface $em){
        
        parent::__construct();

        $this->em = $em;
    }
    
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'import-developers';

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Import a new developer.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to import a developper...')
    ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importation en cours');
        

        $reader = Reader::createFromPath('%kernel.root_dir%/../src/Data/developers_middle.csv')
            ->setHeaderOffset(0)
        ;        

        $results = $reader->getrecords();        
        $io->progressStart(iterator_count($results));
        
        //Disable SQL Logging: to avoid huge memory loss.
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

         // Define the size of record, the frequency for persisting the data and the current index of records
         $size = iterator_count($results);
         $batchSize = 1;
         $i = 1;


        foreach ($results as $row) { 

            $developer = $this->em->getRepository(Developer::class)
            ->findOneBy([
                'firstName' => ($row['FIRSTNAME']),
                'lastName'=> ($row['LASTNAME'])
            ]);                      
            

            if (null === $developer) {                
                $developer = new developer;
                $developer
                    ->setFirstName($row['FIRSTNAME'])
                    ->setLastName($row['LASTNAME']);
                $this->em->persist($developer);
            }
                            
            $badgeLabel = $this->em->getRepository(BadgeLabel::class)
                ->findOneBy([
                    'name' => ($row['BADGE LABEL']),
                    'level'=> ($row['BADGE LEVEL'])
                ])
            ;

            if (null === $badgeLabel) {
                $badgeLabel = new BadgeLabel;
                $badgeLabel
                    ->setName($row['BADGE LABEL'])
                    ->setLevel($row['BADGE LEVEL']);
                $this->em->persist($badgeLabel);
            }
            $developer
                ->addBadgeLabel($badgeLabel);
            
            if (($i % $batchSize) === 0) {
                $this->em->flush();
                // Detaches all objects from Doctrine for memory save
                $this->em->clear();
            }
            $i++;
            $io->progressAdvance();

        }
        
        $this->em->flush();
        $this->em->clear();

        $io->progressFinish();
        $io->success('Importation terminée avec succès');
    }
}