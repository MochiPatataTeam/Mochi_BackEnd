<?php

namespace App\Repository;

use App\Entity\Mensaje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Driver\ResultStatement;

/**
 * @extends ServiceEntityRepository<Mensaje>
 *
 * @method Mensaje|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mensaje|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mensaje[]    findAll()
 * @method Mensaje[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MensajeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mensaje::class);
    }

    public function buscarContactos(int $idReceptor)
    {
        $entityManager = $this->getEntityManager();

        $sql = 'SELECT u.nombre, u.id FROM mochi.mensaje m
                JOIN mochi.usuario u ON (m.id_emisor = u.id OR m.id_receptor = u.id)
                WHERE (m.id_receptor = :idReceptor OR m.id_emisor = :idReceptor)
                AND u.id <> 1
                GROUP BY u.nombre, u.id';

        $query = $entityManager->getConnection()->executeQuery($sql, [
            'idReceptor' => $idReceptor,
        ], [
            'idReceptor' => \PDO::PARAM_INT,
        ]);

        $result = $query->fetchAllAssociative();

        return $result;
    }

    public function buscarMensajes(int $idEmisor, int $idReceptor): array
    {
        $dql = 'SELECT m FROM App\Entity\Mensaje m
                WHERE (m.id_emisor = :idEmisor AND m.id_receptor = :idReceptor)
                OR (m.id_emisor = :idReceptor AND m.id_receptor = :idEmisor)';

        $mensajes = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('idEmisor', $idEmisor)
            ->setParameter('idReceptor', $idReceptor)
            ->getResult();

        return $mensajes;
    }



//    /**
//     * @return Mensaje[] Returns an array of Mensaje objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Mensaje
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
