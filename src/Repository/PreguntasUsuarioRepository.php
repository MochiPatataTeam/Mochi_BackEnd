<?php

namespace App\Repository;

use App\Entity\PreguntasUsuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PreguntasUsuario>
 *
 * @method PreguntasUsuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreguntasUsuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreguntasUsuario[]    findAll()
 * @method PreguntasUsuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreguntasUsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PreguntasUsuario::class);
    }

//    /**
//     * @return PreguntasUsuario[] Returns an array of PreguntasUsuario objects
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

//    public function findOneBySomeField($value): ?PreguntasUsuario
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
