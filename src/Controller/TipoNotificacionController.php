<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TipoNotificacionRepository;
use App\Entity\TipoNotificacion;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/tipo')]
class TipoNotificacionController extends AbstractController
{
    #[Route('', name: 'lista_tipos', methods: ['GET'])]
    public function list(TipoNotificacionRepository $tipoRepository): JsonResponse
    {
        $tipos = $tipoRepository->findAll();


        return $this->json($tipos);
    }
}
