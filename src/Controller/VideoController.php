<?php

namespace App\Controller;

use App\DTOs\VideoDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VideoRepository;
use App\Entity\Video;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
#[Route('/api/video')]
class VideoController extends AbstractController
{
    #[Route('', name: 'lista_video', methods: ['GET'])]
    public function list(VideoRepository $videoRepository): JsonResponse
    {
        $listaVideos = $videoRepository->findAll();

        $listaVideosDTO=[];

        foreach ($listaVideos as $video){
            $videoDTO = new VideoDTO();
            $videoDTO -> setId($video->getId());
            $videoDTO ->setTitulo($video->getTitulo());
            $videoDTO ->setDescripcion($video->getDescripcion());
            $videoDTO ->setUrl($video->getUrl());
            $videoDTO ->setCanal($video->getCanal()->getNombreCanal());

            $listaVideosDTO[]=$videoDTO;
        }
        return $this->json($listaVideosDTO, Response::HTTP_OK);
    }
}
