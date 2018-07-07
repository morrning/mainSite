<?php

namespace App\Repository;

use App\Entity\SysFileFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SysFileFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method SysFileFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method SysFileFile[]    findAll()
 * @method SysFileFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SysFileFileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SysFileFile::class);
    }

//    /**
//     * @return SysFileFile[] Returns an array of SysFileFile objects
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
    public function findOneBySomeField($value): ?SysFileFile
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
