<?php

namespace App\Repository;

use App\Entity\MovieAward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MovieAward|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieAward|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieAward[]    findAll()
 * @method MovieAward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieAwardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MovieAward::class);
    }
}
