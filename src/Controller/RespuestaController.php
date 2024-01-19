<?php

namespace App\Controller;

use App\DTOs\RespuestaDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RespuestaRepository;
use App\Entity\Respuesta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/respuesta')]
class RespuestaController extends AbstractController
{
    #[Route('', name: 'lista_respuesta', methods: ['GET'])]
    public function lista_respuesta(RespuestaRepository $respuestaRepository): JsonResponse
    {
        $listaRespuestas = $respuestaRepository->findAll();

        $listaRespuestasDTO = [];

        foreach ($listaRespuestas as $respuesta){
            $respuestaDTO = new RespuestaDTO();
            $respuestaDTO->setId($respuesta->getId());
            $respuestaDTO->setMensaje($respuesta->getMensaje());


            $listaRespuestasDTO[]=$respuestaDTO;
        }
        return $this->json($listaRespuestasDTO, Response::HTTP_OK);
    }
}
