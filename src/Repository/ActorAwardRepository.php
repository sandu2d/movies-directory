<?php

namespace App\Repository;

use App\Entity\ActorAward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActorAward|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActorAward|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActorAward[]    findAll()
 * @method ActorAward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActorAwardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActorAward::class);
    }

    // /**
    //  * @return ActorAward[] Returns an array of ActorAward objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActorAward
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
