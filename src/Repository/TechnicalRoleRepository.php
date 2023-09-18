<?php

namespace App\Repository;

use App\Entity\TechnicalRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechnicalRole>
 *
 * @method TechnicalRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnicalRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnicalRole[]    findAll()
 * @method TechnicalRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnicalRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnicalRole::class);
    }

//    /**
//     * @return TechnicalRole[] Returns an array of TechnicalRole objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TechnicalRole
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
