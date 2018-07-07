<?php

namespace App\Repository;

use App\Entity\SysFileFolder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SysFileFolder|null find($id, $lockMode = null, $lockVersion = null)
 * @method SysFileFolder|null findOneBy(array $criteria, array $orderBy = null)
 * @method SysFileFolder[]    findAll()
 * @method SysFileFolder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SysFileFolderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SysFileFolder::class);
    }

//    /**
//     * @return SysFileFolder[] Returns an array of SysFileFolder objects
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
    public function findOneBySomeField($value): ?SysFileFolder
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
