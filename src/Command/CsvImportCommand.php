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
    protected static $defaultName = 'import-developpers';

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Import a new developper.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to import a develpper...')
    ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importation en cours');
        

        $reader = Reader::createFromPath('%kernel.root_dir%/../src/Data/developers_simple.csv')
            ->setHeaderOffset(0)
        ;        

        $results = $reader->getrecords();        
        $io->progressStart(iterator_count($results));
        
        //Disable SQL Logging: to avoid huge memory loss.
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);


        foreach ($results as $row) {                     
            $developer = $this->em->getRepository(Developer::class)
            ->findOneBy([
                'firstName' => ($row['FIRSTNAME']),
                'lastName'=> ($row['LASTNAME'])
            ]);
            dump($developer);die;         
            

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
                $this->em->flush();
                $this->em->clear();

            }
            $developer
                ->addBadgeLabel($badgeLabel);
            
            $io->progressAdvance();
        }
        
        $this->em->flush();
        $this->em->clear();

        $io->progressFinish();
        $io->success('Importation terminée avec succès');
    }
}