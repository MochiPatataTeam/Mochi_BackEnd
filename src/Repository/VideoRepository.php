<?php

namespace App\Repository;


use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Driver\ResultStatement;

/**
 * @extends ServiceEntityRepository<Video>
 *
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    public function buscarvideoID(int $id)
    {
        return $this->createQueryBuilder('v')
            ->where('v.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //query suscripciones
    public function buscarvideosuscripcion(int $id) {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT * FROM mochi.video v JOIN mochi.suscripcion s ON s.id_canal = v.id_canal WHERE s.id_suscriptor = :id';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id' => $id,], ['id' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    //query tematica
    public function buscarvideotematica (int $id){
        $entityManager = $this->getEntityManager();
        $sql= 'SELECT * FROM mochi.video v JOIN mochi.tematica t ON t.id = v.id_tematica WHERE t.id = :id order by v.id asc limit 2';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id' => $id,], ['id' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

}
