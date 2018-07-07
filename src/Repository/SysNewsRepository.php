<?php

namespace App\Repository;

use App\Entity\SysNews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SysNews|null find($id, $lockMode = null, $lockVersion = null)
 * @method SysNews|null findOneBy(array $criteria, array $orderBy = null)
 * @method SysNews[]    findAll()
 * @method SysNews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SysNewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SysNews::class);
    }

//    /**
//     * @return SysNews[] Returns an array of SysNews objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SysNews
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
