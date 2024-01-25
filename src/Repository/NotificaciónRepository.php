<?php

namespace App\Repository;

use App\Entity\Notificación;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notificación>
 *
 * @method Notificación|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notificación|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notificación[]    findAll()
 * @method Notificación[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificaciónRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notificación::class);
    }

//    /**
//     * @return Notificación[] Returns an array of Notificación objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Notificación
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
