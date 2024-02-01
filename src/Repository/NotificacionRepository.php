<?php

namespace App\Repository;

use App\Entity\Notificacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notificacion>
 *
 * @method Notificacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notificacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notificacion[]    findAll()
 * @method Notificacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notificacion::class);
    }


    public function buscarNotificaciones(int $idPersona)
    {
        $entityManager = $this->getEntityManager();

        $sql = 'SELECT n.*, tn.tipo, u.username
                    FROM mochi.notificacion n
                    JOIN mochi.tipo_notificacion tn ON tn.id = n.id_tipo
                    JOIN mochi.usuario u ON u.id = n.id_creador
                    WHERE n.id_usuario = :idPersona ';

        $query = $entityManager->getConnection()->executeQuery($sql, [
            'idPersona' => $idPersona,
        ], [
            'idPersona' => \PDO::PARAM_INT,
        ]);

        $result = $query->fetchAllAssociative();

        return $result;
    }



//    /**
//     * @return Notificacion[] Returns an array of Notificacion objects
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

//    public function findOneBySomeField($value): ?Notificacion
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
