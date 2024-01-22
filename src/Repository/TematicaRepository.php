<?php

namespace App\Repository;

use App\Entity\Tematica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tematica>
 *
 * @method Tematica|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tematica|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tematica[]    findAll()
 * @method Tematica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TematicaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tematica::class);
    }

//    /**
//     * @return Tematica[] Returns an array of Tematica objects
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

//    public function findOneBySomeField($value): ?Tematica
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
