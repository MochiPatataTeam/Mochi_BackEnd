<?php

namespace App\Repository;

use App\Entity\Comentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Driver\ResultStatement;

/**
 * @extends ServiceEntityRepository<Comentario>
 *
 * @method Comentario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comentario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comentario[]    findAll()
 * @method Comentario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comentario::class);
    }

    public function comentariovideoID(int $id)
    {
//        return $this->createQueryBuilder('c')
//            ->select('c.id, c.fav, c.comentario, c.dislike')
//            ->join('c.video', 'v')
//            ->where('v.id = :id')
//            ->setParameter('id', $id)
//            ->getQuery()
//            ->getResult();
        $entityManager = $this->getEntityManager();
        $sql = 'select c.id, c.fav, c.dislike, u.username, c.comentario from mochi.comentario c 
                join mochi.video v on v.id = c.id_video 
                join mochi.usuario u on c.id_usuario = u.id
                where v.id=:id';

        $query = $entityManager->getConnection()->executeQuery($sql,['id'=>$id,],['id'=>\PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;


    }

}
