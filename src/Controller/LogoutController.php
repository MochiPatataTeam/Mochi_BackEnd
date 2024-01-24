<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/logout')]
class LogoutController extends AbstractController
{
    #[Route('', name: 'app_logout', methods: ['GET'])]
    public function logout():  JsonResponse
    {
        return new JsonResponse(['message' => 'Deslogueado']);
//        throw new \Exception('Dont forget to activate logout in security.yaml');
    }
}
