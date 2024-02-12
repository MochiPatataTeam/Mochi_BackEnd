<?php

namespace App\Repository;

use App\Entity\Suscripcion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Suscripcion>
 *
 * @method Suscripcion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suscripcion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suscripcion[]    findAll()
 * @method Suscripcion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuscripcionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suscripcion::class);
    }

    public function suscripcionid (int $id_suscriptor, int $id_canal){
        $entityManager = $this->getEntityManager();
        $sql= 'select s.* from mochi.suscripcion s where s.id_suscriptor = :id_suscriptor and s.id_canal = :id_canal;';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id_suscriptor' => $id_suscriptor,'id_canal' => $id_canal,], ['id_suscriptor' => \PDO::PARAM_INT,'id_canal' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    public function suscripciontotal (int $id_canal){
        $entityManager = $this->getEntityManager();
        $sql= 'select count(s.sub) as total_subs from mochi.suscripcion s where s.id_canal = :id_canal and s.sub = true';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id_canal' => $id_canal,], ['id_canal' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

}
