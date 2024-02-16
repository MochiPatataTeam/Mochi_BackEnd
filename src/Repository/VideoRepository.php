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

    //query suscripciones capado a 2
    public function buscarvideosuscripcion(int $id) {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT v.id, v.titulo, v.descripcion, v.url, v.id_canal, u.nombre_canal, u.imagen, t.tematica FROM mochi.video v  
        JOIN mochi.suscripcion s ON s.id_canal = v.id_canal
        JOIN mochi.tematica t ON t.id = v.id_tematica
        join mochi.usuario u on v.id_canal = u.id
        WHERE s.id_suscriptor = :id order by v.id limit 2';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id' => $id,], ['id' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    //query tematica de video
    public function buscarvideotematica (int $id){
        $entityManager = $this->getEntityManager();
        $sql= 'SELECT v.id, v.titulo, v.descripcion, v.url, v.id_canal, u.nombre_canal, u.imagen, t.tematica FROM mochi.video v 
        JOIN mochi.tematica t ON t.id = v.id_tematica
        join mochi.usuario u on v.id_canal = u.id
        WHERE t.id = :id order by v.id asc limit 2;';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id' => $id,], ['id' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    public function cogerIdUsuarioVideo(int $id){
        $entityManager = $this->getEntityManager();
        $sql='select id_canal from mochi.video where id=:id';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id' => $id,], ['id' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }
    //buscar todos los videos de todas las suscripciones
    public function buscarTodosVideosSuscripcion(int $id) {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT v.id, v.titulo, v.descripcion, v.url, u.nombre_canal, t.tematica from mochi.video v 
        JOIN mochi.suscripcion s ON s.id_canal = v.id_canal 
        join mochi.usuario u on u.id = v.id_canal 
        join mochi.tematica t on v.id_tematica = t.id
        WHERE s.id_suscriptor=:id order by v.id';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id' => $id,], ['id' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }
    public function buscarTitulos(string $titulo)
    {
        $entityManager = $this->getEntityManager();

        $sql = 'SELECT v.*, u.nombre_canal, u.imagen  
            FROM mochi.video v 
            JOIN mochi.usuario u ON u.id = v.id_canal
            WHERE v.titulo LIKE :titulo';

        $query = $entityManager->getConnection()->executeQuery($sql, [
            'titulo' => '%' . $titulo . '%',
        ], [
            'titulo' => \PDO::PARAM_STR,
        ]);

        $result = $query->fetchAllAssociative();

        return $result;
    }
    public function buscarCanal(string $canal)
    {
        $entityManager = $this->getEntityManager();

        $sql = 'SELECT *
                FROM mochi.usuario u 
                WHERE u.nombre_canal LIKE :canal';

        $query = $entityManager->getConnection()->executeQuery($sql, [
            'canal' => '%' . $canal . '%',
        ], [
            'canal' => \PDO::PARAM_STR,
        ]);

        $result = $query->fetchAllAssociative();

        return $result;
    }
}
