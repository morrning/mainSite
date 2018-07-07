<?php

namespace App\Repository;

use App\Entity\SysSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SysSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method SysSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method SysSettings[]    findAll()
 * @method SysSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SysSettingsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SysSettings::class);
    }

//    /**
//     * @return SysSettings[] Returns an array of SysSettings objects
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
    public function findOneBySomeField($value): ?SysSettings
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
