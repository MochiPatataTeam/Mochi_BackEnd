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

#[Route('/api/usuario')]
class UsuarioController extends AbstractController
{
    #[Route('', name: 'lista_usuario', methods: ['GET'])]
    public function list(UsuarioRepository $usuarioRepository): JsonResponse
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
}


