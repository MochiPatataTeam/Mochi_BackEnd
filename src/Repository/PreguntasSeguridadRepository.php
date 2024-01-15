<?php

namespace App\Repository;

use App\Entity\PreguntasSeguridad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PreguntasSeguridad>
 *
 * @method PreguntasSeguridad|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreguntasSeguridad|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreguntasSeguridad[]    findAll()
 * @method PreguntasSeguridad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreguntasSeguridadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PreguntasSeguridad::class);
    }

//    /**
//     * @return PreguntasSeguridad[] Returns an array of PreguntasSeguridad objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PreguntasSeguridad
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
