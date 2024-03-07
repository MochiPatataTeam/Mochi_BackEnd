<?php

namespace App\Repository;

use App\Entity\Valoracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Valoracion>
 *
 * @method Valoracion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valoracion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valoracion[]    findAll()
 * @method Valoracion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValoracionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Valoracion::class);
    }

    public function visualizacionTotal (int $id){
        $entityManager = $this->getEntityManager();
        $sql= 'select  sum(v.visualizacion) as visualizacion from mochi.valoracion v where v.id_video = :id ';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id' => $id,], ['id' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    public function favTotal (int $id){
        $entityManager = $this->getEntityManager();
        $sql= 'select  count(v.fav) as fav from mochi.valoracion v where v.fav = true and v.id_video = :id ';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id' => $id,], ['id' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    public function dislikeTotal (int $id){
        $entityManager = $this->getEntityManager();
        $sql= 'select  count(dislike) as dislike from mochi.valoracion v where v.dislike = true and v.id_video = :id ';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id' => $id,], ['id' => \PDO::PARAM_INT,]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    public function valoracionPorId(int $id_video, ?int $id_usuario)
    {
        $entityManager = $this->getEntityManager();
        $sql= 'SELECT * FROM mochi.valoracion v WHERE v.id_video = :id_video';

        // Si $id_usuario es null, agregamos la condición IS NULL a la consulta
        if ($id_usuario === null) {
            $sql .= ' AND v.id_usuario IS NULL';
        } else {
            $sql .= ' AND v.id_usuario = :id_usuario';
        }

        // Creamos un array para los parámetros que pasaremos a la consulta
        $params = ['id_video' => $id_video];

        // Si $id_usuario no es null, lo agregamos a los parámetros
        if ($id_usuario !== null) {
            $params['id_usuario'] = $id_usuario;
        }

        // Ejecutamos la consulta con los parámetros correspondientes
        $query = $entityManager->getConnection()->executeQuery($sql, $params, ['id_video' => \PDO::PARAM_INT]);

        $result = $query->fetchAllAssociative();
        return $result;
    }

    public function favYDislikePorVideo (int $id_video, ?int $id_usuario){
        $entityManager = $this->getEntityManager();
        $sql= 'select * from mochi.valoracion v where v.id_video = :id_video and v.id_usuario = :id_usuario';
        $query = $entityManager->getConnection()->executeQuery($sql, ['id_video' => $id_video, 'id_usuario' => $id_usuario,], ['id_video' => \PDO::PARAM_INT,'id_usuario' => \PDO::PARAM_INT]);
        $result = $query->fetchAllAssociative();
        return $result;
    }


}
