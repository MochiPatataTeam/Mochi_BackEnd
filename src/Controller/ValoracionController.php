<?php

namespace App\Controller;

use App\DTOs\ValoracionDTO;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ValoracionRepository;
use App\Entity\Valoracion;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
#[Route('/api/valoracion')]
class ValoracionController extends AbstractController
{
#[Route('', name: 'lista_valoraciones', methods: ['GET'])]
public function lista_valoracion(ValoracionRepository $valoracionRepository): JsonResponse
{
    $listaValoraciones = $valoracionRepository->findAll();

    $listaValoracionesDTO = [];

    foreach($listaValoraciones as $valoracion){
        $valoracionDTO = new ValoracionDTO();
        $valoracionDTO->setId($valoracion->getId());
        $valoracionDTO->setFav($valoracion->getFav());
        $valoracionDTO->setDislike($valoracion->getDislike());
        $valoracionDTO->setVisualizacion($valoracion->getVisualizacion());
        $valoracionDTO->setVideo($valoracion->getVideo()->getTitulo());
        $valoracionDTO->setUsuario($valoracion->getUsuario()->getUsername());

        $listaValoracionesDTO[]=$valoracionDTO;
    }
    return $this->json($listaValoracionesDTO, Response::HTTP_OK);
}
}
