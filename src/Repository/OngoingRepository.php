<?php

namespace App\Repository;

use App\Entity\Ongoing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ongoing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ongoing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ongoing[]    findAll()
 * @method Ongoing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OngoingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ongoing::class);
    }

    // /**
    //  * @return Ongoing[] Returns an array of Ongoing objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ongoing
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
