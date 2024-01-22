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
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuario;
use App\Entity\Tematica;

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
            $videoDTO->setTematica($video->getTematica()->getTematica());

            $listaVideosDTO[]=$videoDTO;
        }
        return $this->json($listaVideosDTO, Response::HTTP_OK);
    }

    #[Route('', name: 'crear_video', methods: ['POST'])]
    public function crearvideo (EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data =json_decode($request->getContent(),true);

        $nuevoVideo = new Video();
        $nuevoVideo->setTitulo($data['titulo']);
        $nuevoVideo->setDescripcion($data['descripcion']);
        $nuevoVideo->setUrl($data['url']);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id" => $data['canal']]);
        $nuevoVideo->setCanal($usuario[0]);
        $tematica =$entityManager->getRepository(Tematica::class)->findBy(["id" => $data['tematica']]);
        $nuevoVideo->setTematica($tematica[0]);

        $entityManager->persist($nuevoVideo);
        $entityManager->flush();

        return $this->json(['message' => 'Video creado'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: "editar_video", methods: ["PUT"])]
    public function editarvideo (EntityManagerInterface $entityManager, Request $request, $id):JsonResponse
    {
        $data = json_decode($request-> getContent(), true);

        $video = $entityManager->getRepository(Video::class)->find($id);
        if (!$video) {
            return $this->json(['message' => 'Video no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $video->setTitulo($data['titulo']);
        $video->setDescripcion($data['descripcion']);
        $video->setUrl($data['url']);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id" => $data['canal']]);
        $video->setCanal($usuario[0]);
        $tematica =$entityManager->getRepository(Tematica::class)->findBy(["id" => $data['tematica']]);
        $video->setTematica($tematica[0]);

        $entityManager->flush();

        return $this->json(['message' => 'Video modificado'], Response::HTTP_OK);

    }
    #[Route('/{id}', name: "delete_by_id", methods: ["DELETE"])]
    public function deleteById(EntityManagerInterface $entityManager, $id):JsonResponse
    {

        $video = $entityManager->getRepository(Video::class)->find($id);

        $entityManager->remove($video);
        $entityManager->flush();

        return $this->json(['message' => 'Video eliminado'], Response::HTTP_OK);

    }

}
