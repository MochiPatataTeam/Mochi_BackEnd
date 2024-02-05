<?php

namespace App\Repository;

use App\Entity\Respuesta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Respuesta>
 *
 * @method Respuesta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Respuesta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Respuesta[]    findAll()
 * @method Respuesta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RespuestaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Respuesta::class);
    }

    public function respuestavideoID(int $id, int $id_comentario)
    {
        $entityManager = $this->getEntityManager();
        $sql = 'select c.id, c.fav, c.dislike, u.username, c.comentario, r.id as respuesta_id, ru.username as respuesta_username, r.mensaje  from mochi.comentario c 
                join mochi.video v on v.id = c.id_video 
                join mochi.usuario u on c.id_usuario = u.id
                join mochi.respuesta r on r.id_comentario = c.id
                join mochi.usuario ru on ru.id = r.id_usuario 
                where v.id=:id and r.id_comentario = :comentario';

        $query = $entityManager->getConnection()->executeQuery($sql,['id'=>$id,'comentario'=>$id_comentario],['id'=>\PDO::PARAM_INT,'comentario'=>\PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }
}
