<?php

namespace App\Repository;

use App\DTOs\UsuarioDTO;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\String\u;

/**
 * @extends ServiceEntityRepository<Usuario>
 *
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function buscarId(string $username): array
    {
        $entityManager = $this->getEntityManager();

        $sql = 'SELECT u.id FROM mochi.usuario u WHERE u.username  = :username';

        $query = $entityManager->getConnection()->executeQuery($sql, [
            'username' => $username,
        ], [
            'username' => \PDO::PARAM_STR,
        ]);

        $result = $query->fetchAllAssociative();

        return $result;
    }
    public function buscarIdCanal(string $canal): array
    {
        $entityManager = $this->getEntityManager();

        $sql = 'SELECT u.id FROM mochi.usuario u WHERE u.nombre_canal  = :canal';

        $query = $entityManager->getConnection()->executeQuery($sql, [
            'canal' =>  $canal,
        ], [
            'canal' => \PDO::PARAM_STR,
        ]);

        $result = $query->fetchAllAssociative();

        return $result;
    }


    public function getById(int $id)
    {
        $entityManager = $this -> getEntityManager();
        $sql = 'select u.id , u.nombre , u.apellidos , u.username , u.email , u.telefono , u.nombre_canal , u.descripcion , u.suscriptores , u.imagen 
                from mochi.usuario u where u.id = :id';

        $query = $entityManager -> getConnection() -> executeQuery($sql, ['id'=>$id],['id'=>\PDO::PARAM_INT]);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    public function getByCanal(string $nombreCanal)
    {
        $entityManager = $this -> getEntityManager();
        $sql = 'select u.id , u.nombre , u.apellidos , u.username , u.email , u.telefono , u.nombre_canal , u.descripcion , u.suscriptores , u.imagen 
                from mochi.usuario u where u.nombre_canal = :nombreCanal';

        $query = $entityManager -> getConnection() -> executeQuery($sql, ['nombreCanal'=>$nombreCanal],['nombreCanal'=>\PDO::PARAM_INT]);
        $result = $query->fetchAllAssociative();
        return $result;
    }




//    /**
//     * @return Usuario[] Returns an array of Usuario objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Usuario
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
