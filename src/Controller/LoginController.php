<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/api/login')]
class LoginController extends AbstractController
{
    #[Route('', name: 'login', methods: ['POST'])]
    public function index(AuthenticationUtils $authenticationUtils, Request $request): JsonResponse
    {
        $error= $authenticationUtils->getLastAuthenticationError(); //muestra error del formulario que se haya producido
        $lastUsername= $authenticationUtils->getLastUsername(); //si falla, dejar relleno el campo de username

        return new JsonResponse([
            'last_username' => $lastUsername,
            'error' => $error,
            ['message' => 'logueado!']
        ]);
    }
}
