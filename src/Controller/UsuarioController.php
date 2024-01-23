<?php


namespace App\Controller;


use App\DTOs\UsuarioDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsuarioRepository;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/api/usuario')]
class UsuarioController extends AbstractController
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
    //Crear usuario
    #[Route('', name: 'crear_usuario', methods: ['POST'])]
    public function crearusuario(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuario = new Usuario();
        $usuario->setNombre($data['nombre']);
        $usuario->setApellidos($data['apellidos']);
        $usuario->setUsername($data['username']);
        $usuario->setPassword($data['password']);
        $usuario->setEmail($data['email']);
        $usuario->setTelefono($data['telefono']);
        $usuario->setNombreCanal($data['nombreCanal']);
        $usuario->setDescripcion($data['descripcion']);
        $usuario->setImagen($data['imagen']);

        $entityManager->persist($usuario);
        $entityManager->flush();

        return $this->json(['message' => 'Usuario creado'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'update_usuario', methods: ['PUT'])]
    public function editarusuario (EntityManagerInterface $entityManager, Request $request, $id): JsonResponse
    {
        $data =json_decode($request->getContent(),true);

        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        if (!$usuario){
            return $this->json(['message' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }
        $usuario->setNombre($data['nombre']);
        $usuario->setApellidos($data['apellidos']);
        $usuario->setUsername($data['username']);
        $usuario->setPassword($data['password']);
        $usuario->setEmail($data['email']);
        $usuario->setTelefono($data['telefono']);
        $usuario->setNombreCanal($data['nombreCanal']);
        $usuario->setDescripcion($data['descripcion']);
        $usuario->setImagen($data['imagen']);

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

}


