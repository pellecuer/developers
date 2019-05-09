<?php

namespace App\Repository;

use App\Entity\BadgeLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BadgeLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method BadgeLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method BadgeLabel[]    findAll()
 * @method BadgeLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BadgeLabelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BadgeLabel::class);
    }

    // /**
    //  * @return BadgeLabel[] Returns an array of BadgeLabel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BadgeLabel
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
