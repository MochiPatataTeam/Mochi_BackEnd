<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsuarioRepository;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



#[Route('/api/usuario')] //prueba
class UsuarioController extends AbstractController
{
    #[Route('', name: 'lista_usuario', methods: ['GET'])]
    public function list(UsuarioRepository $usuarioRepository): JsonResponse
    {
        $usuarios = $usuarioRepository->findAll();

        return $this->json($usuarios);
    }
}
