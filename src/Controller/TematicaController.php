<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TematicaRepository;
use App\Entity\Tematica;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/tematica')]
class TematicaController extends AbstractController
{
    #[Route('', name: 'lista_tematica', methods: ['GET'])]
    public function lista_tematica(TematicaRepository $tematicaRepository): JsonResponse
    {
        $tematicas = $tematicaRepository->findAll();


        return $this->json($tematicas);
    }
}
