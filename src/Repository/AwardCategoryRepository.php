<?php

namespace App\Repository;

use App\Entity\AwardCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AwardCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AwardCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AwardCategory[]    findAll()
 * @method AwardCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AwardCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AwardCategory::class);
    }

    // /**
    //  * @return AwardCategory[] Returns an array of AwardCategory objects
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
    public function findOneBySomeField($value): ?AwardCategory
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
