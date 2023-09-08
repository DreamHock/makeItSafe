<?php

namespace App\Repository;

use App\Entity\Complexity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Complexity>
 *
 * @method Complexity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Complexity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Complexity[]    findAll()
 * @method Complexity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComplexityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Complexity::class);
    }

//    /**
//     * @return Complexity[] Returns an array of Complexity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Complexity
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
