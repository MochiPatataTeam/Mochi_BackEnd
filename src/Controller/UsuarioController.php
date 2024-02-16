<?php


namespace App\Controller;


use App\DTOs\UsuarioDTO;
use App\Repository\SuscripcionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsuarioRepository;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

#[Route('/api/usuario')]
class   UsuarioController extends AbstractController
{
    //listar con DTOs
    #[Route('', name: 'lista_usuario', methods: ['GET'])]
    public function listausuarios(UsuarioRepository $usuarioRepository): JsonResponse
    {
        $listaUsuarios = $usuarioRepository->findAll();

        $listaUsuariosDTO=[];

        foreach($listaUsuarios as $usuario){
            $usuarioDTO =new UsuarioDTO();
            $usuarioDTO->setId($usuario->getId());
            $usuarioDTO->setNombre($usuario->getNombre());
            $usuarioDTO->setApellidos($usuario->getApellidos());
            $usuarioDTO->setUsername($usuario->getUsername());
            $usuarioDTO->setPassword($usuario->getPassword());
            $usuarioDTO->setEmail($usuario->getEmail());
            $usuarioDTO->setTelefono($usuario->getTelefono());
            $usuarioDTO->setNombreCanal($usuario->getNombreCanal());
            $usuarioDTO->setDescripcion($usuario->getDescripcion());
            $usuarioDTO->setSuscriptores($usuario->getSuscriptores());

            $listaUsuariosDTO[]=$usuarioDTO;
        }
        return $this->json($listaUsuariosDTO, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'update_usuario', methods: ['PUT'])]
    public function editarusuario (EntityManagerInterface $entityManager, Request $request, $id, SuscripcionRepository $suscripcionRepository): JsonResponse
    {
        $data =json_decode($request->getContent(),true);

        $usuario = $entityManager->getRepository(Usuario::class)->find($id);
//        $suscripcion = $suscripcionRepository->suscripciontotal($id);
        if (!$usuario){
            return $this->json(['message' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $usuario->setNombre($data['nombre']);
        $usuario->setApellidos($data['apellidos']);
        $usuario->setUsername($data['username']);
        $usuario->setEmail($data['email']);
        $usuario->setTelefono($data['telefono']);
        $usuario->setNombreCanal($data['nombre_canal']);
        $usuario->setDescripcion($data['descripcion']);
//        $usuario->setSuscriptores($suscripcion[0]['total_subs']);

        $entityManager->flush();
        return $this->json(['message' => 'Usuario actualizado']);
    }
    #[Route('/{id}', name: "delete_usuario_by_id", methods: ["DELETE"])]
    public function deleteUserById(EntityManagerInterface $entityManager, $id):JsonResponse
    {
        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        $entityManager->remove($usuario);
        $entityManager->flush();

        return $this->json(['message' => 'Usuario eliminado'], Response::HTTP_OK);
    }





    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/query', name: 'lista_usuario2', methods: ['GET'])]
    public function listaconquery()
    {
        // Obtén el EntityManager
        $entityManager = $this->entityManager;

        // Crea la consulta nativa
        $sql = 'SELECT u.nombre, u.apellidos, u.username, u.password, u.email, u.telefono, u.nombre_canal, u.descripcion FROM mochi.usuario u';

        $nativeQuery = $entityManager->createNativeQuery($sql, new ResultSetMapping());

        // Ejecuta la consulta
        $result = $nativeQuery->getResult();


        var_dump($sql);
        var_dump($result);

        $listaUsuariosDTO1=[];

        // Mapea los resultados a objetos UsuarioDTO
        foreach ($result as $prueba) {
            $usuarioDTO = new UsuarioDTO();
            $usuarioDTO->setNombre($prueba['nombre'] ?? null);
            $usuarioDTO->setApellidos($prueba['apellidos'] ?? null);
            $usuarioDTO->setUsername($prueba['username'] ?? null);
            $usuarioDTO->setPassword($prueba['password'] ?? null);
            $usuarioDTO->setEmail($prueba['email'] ?? null);
            $usuarioDTO->setTelefono($prueba['telefono'] ?? null);
            $usuarioDTO->setNombreCanal($prueba['nombre_canal'] ?? null);
            $usuarioDTO->setDescripcion($prueba['descripcion'] ?? null);

            $listaUsuariosDTO1[] = $usuarioDTO;
        }


        // Devuelve la lista de DTOs como una respuesta JSON
        return $this->json($listaUsuariosDTO1, Response::HTTP_OK);
    }

    #[Route('/buscarId', name: "buscarId_username", methods: ["GET"])]
    public function buscarId(Request $request, UsuarioRepository $usuarioRepository):JsonResponse
    {
        $username = $request->query->get('username');

        if ($username === null) {
            return $this->json($username, Response::HTTP_BAD_REQUEST);
        }

        $user = $usuarioRepository->buscarId($username);

        return $this->json($user, Response::HTTP_OK);
    }


    #[Route('/{id}', name: 'getById', methods: ["GET"])]
    public function getById(UsuarioRepository $usuarioRepository, int $id): JsonResponse
    {
        $usuarios = $usuarioRepository -> getById($id);

        foreach ($usuarios as $usuario){
            $usuarioDTO = new UsuarioDTO();
            $usuarioDTO->setId($usuario['id']);
            $usuarioDTO->setNombre($usuario['nombre']);
            $usuarioDTO->setApellidos($usuario['apellidos']);
            $usuarioDTO->setUsername($usuario['username']);
            $usuarioDTO->setEmail($usuario['email']);
            $usuarioDTO->setTelefono($usuario['telefono']);
            $usuarioDTO->setNombreCanal($usuario['nombre_canal']);
            $usuarioDTO->setDescripcion($usuario['descripcion']);
            $usuarioDTO->setSuscriptores($usuario['suscriptores']);
            $usuarioDTO->setImagen($usuario['imagen']);
        }

        return $this -> json($usuarioDTO, Response::HTTP_OK);
    }


    #[Route('/canal/{canal}', name: 'getByNombreCanal', methods: ["GET"])]
    public function getByCanal(UsuarioRepository $usuarioRepository, string $canal): JsonResponse
    {
        $usuarios = $usuarioRepository -> getByCanal($canal);

        foreach ($usuarios as $usuario){
            $usuarioDTO = new UsuarioDTO();
            $usuarioDTO->setId($usuario['id']);
            $usuarioDTO->setNombre($usuario['nombre']);
            $usuarioDTO->setApellidos($usuario['apellidos']);
            $usuarioDTO->setUsername($usuario['username']);
            $usuarioDTO->setEmail($usuario['email']);
            $usuarioDTO->setTelefono($usuario['telefono']);
            $usuarioDTO->setNombreCanal($usuario['nombre_canal']);
            $usuarioDTO->setDescripcion($usuario['descripcion']);
            $usuarioDTO->setSuscriptores($usuario['suscriptores']);
            $usuarioDTO->setImagen($usuario['imagen']);
        }

        return $this -> json($usuarioDTO, Response::HTTP_OK);
    }

}


