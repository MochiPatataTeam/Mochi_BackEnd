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

    public function respuestavideoID(int $id)
    {
        return $this->createQueryBuilder('r')
            ->select('c.id as comentario_id', 'c.fav', 'c.dislike','c.comentario', 'u.username as username_respuesta','r.id' ,'r.mensaje')
            ->join('r.comentario', 'c')
            ->join('r.usuario', 'u')
            ->where('c.id = :id_comentario')
            ->setParameter('id_comentario', $id)
            ->getQuery()
            ->getResult();
    }
}
