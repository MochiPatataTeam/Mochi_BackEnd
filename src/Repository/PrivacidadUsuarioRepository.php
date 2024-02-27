<?php

namespace App\Repository;

use App\Entity\PrivacidadUsuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrivacidadUsuario>
 *
 * @method PrivacidadUsuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrivacidadUsuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrivacidadUsuario[]    findAll()
 * @method PrivacidadUsuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivacidadUsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrivacidadUsuario::class);
    }


    public function getById(int $id)
    {
        $entityManager = $this -> getEntityManager();
        $sql = 'select * from mochi.privacidad_usuario pu where id_usuario = :id';

        $query = $entityManager -> getConnection() -> executeQuery($sql, ['id'=>$id],['id'=>\PDO::PARAM_INT]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    public function getByCanal(string $nombreCanal)
    {
        $entityManager = $this -> getEntityManager();
        $sql = 'select pu.* from mochi.privacidad_usuario pu 
                join mochi.usuario u on u.id = pu.id_usuario where u.nombre_canal = :nombreCanal';

        $query = $entityManager -> getConnection() -> executeQuery($sql, ['nombreCanal'=>$nombreCanal],['nombreCanal '=>\PDO::PARAM_INT]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

//    /**
//     * @return PrivacidadUsuario[] Returns an array of PrivacidadUsuario objects
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

//    public function findOneBySomeField($value): ?PrivacidadUsuario
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
