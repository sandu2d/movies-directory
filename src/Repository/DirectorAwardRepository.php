<?php

namespace App\Repository;

use App\Entity\DirectorAward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DirectorAward|null find($id, $lockMode = null, $lockVersion = null)
 * @method DirectorAward|null findOneBy(array $criteria, array $orderBy = null)
 * @method DirectorAward[]    findAll()
 * @method DirectorAward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirectorAwardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DirectorAward::class);
    }

    // /**
    //  * @return DirectorAward[] Returns an array of DirectorAward objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DirectorAward
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
