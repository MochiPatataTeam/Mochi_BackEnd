<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PreguntasSeguridadRepository;
use App\Entity\PreguntasSeguridad;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/pregunta')]
class PreguntasSeguridadController extends AbstractController
{
    #[Route('', name: 'lista_preguntas_seguridad', methods: ['GET'])]
    public function list_preguntas_seguridad(PreguntasSeguridadRepository $preguntasSeguridadRepository): JsonResponse
    {
        $tipos = $preguntasSeguridadRepository->findAll();


        return $this->json($tipos);
    }
}
