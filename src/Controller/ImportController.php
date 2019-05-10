<?php

namespace App\Controller;

use App\Repository\DeveloperRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Driver\Connection;


class ImportController extends AbstractController
{    

    public function __construct(EntityManagerInterface $em)    {
        
        $this->em = $em;
    }

    /**
     * @Route("/import", name="import")
     */
    public function importdeveloppers(DeveloperRepository $repository, Connection $connection)
    {
        //$rawSql = "SELECT m.id, (SELECT COUNT(i.id) FROM item AS i WHERE i.myclass_id = m.id) AS total FROM myclass AS m";
        //$rawSql = 'INSERT INTO developer (id, first_name, last_name) VALUES (NULL, jean, pellecuer)';

        $developers = $connection->fetchAll('SELECT * FROM developer');
        dump($developers);die;
       
       $rawSql = 'INSERT INTO developer (id, first_name, last_name) VALUES (
            NULL,
            Thomas,            
            Norway);';
        
        $stmt = $this->em
            ->getConnection()
            ->prepare($rawSql);
         //dump($stmt);die;
         $stmt->execute([]);

        return $stmt->fetchAll();
    }

     /**
     * @Route("/import2", name="import2")
     */
    public function importNativeSQL(DeveloperRepository $repository)
    {        
        $rsm = new ResultSetMapping();
        // build rsm here

        $rawSql = $this->em->createNativeQuery('INSERT id, first_name, last_name FROM developer VALUES 
        ID = NULL,
        first_name = Thomas,
        last_name = Begin', $rsm);   
        

        $rawSql_old = 'INSERT INTO developer (id, first_name, last_name) VALUES (
            NULL,
            Thomas,            
            Norway);';
        
        $stmt = $this->em
            ->getConnection()
            ->prepare($rawSql);
        
         $stmt->executeUpdate([]);
        //dump($stmt);die;

        return $stmt->fetchAll();
    }

    

    /**
     * @Route("/import3", name="import3")
     */
    public function findAllGreaterThanPrice(): array
    {
        $conn = $this->em->getConnection();

        $sql = 
            'INSERT INTO developer (first_name, last_name) VALUES 
            (Jean, Paul),
            (Michel, Durant)'
            //'SELECT * FROM developer'
            ;
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        var_dump($stmt->fetchAll());die;

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
        }

    
    /**
     * @Route("/import4", name="import4")
     */
    public function findbyDBAL(Connection $connection)
    {
        $sql = "INSERT INTO developer (id, first_name, last_name) VALUES 
        (1000000003, 'MIchel', 'pellecuer');";
        $pstmt = $connection->prepare($sql);

        // returns an array of arrays (i.e. a raw data set)
        var_dump($connection->fetchAll($sql));die;
        return $connection->fetchAll($sql);
        }



}
