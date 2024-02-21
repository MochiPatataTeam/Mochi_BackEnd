<?php

namespace App\Controller;

use App\DTOs\ComentarioDTO;
use App\DTOs\RespuestaDTO;
use App\DTOs\VideoDTO;
use App\Repository\ComentarioRepository;
use App\Repository\RespuestaRepository;
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

    #[Route('/listarId/{id}', name: "listarVideosPorId", methods: ["GET"])]
    public function videoID(VideoRepository $videoRepository, int $id, ComentarioRepository $comentarioRepository,RespuestaRepository $respuestaRepository): JsonResponse
    {

        $video = $videoRepository ->buscarvideoID($id);
        $comentarios = $comentarioRepository->comentariovideoID($id);


        $videoDTO = new VideoDTO();
        $videoDTO->setId($video->getId());
        $videoDTO->setTitulo($video->getTitulo());
        $videoDTO->setDescripcion($video->getDescripcion());
        $videoDTO->setUrl($video->getUrl());
        $videoDTO->setCanal($video->getCanal()->getNombreCanal());
        $videoDTO->setTematica($video->getTematica()->getTematica());


        $comentariosDTO = [];
        foreach ($comentarios as $comentario) {
            $comentarioDTO = new ComentarioDTO();
            $comentarioDTO->setId($comentario['id']);
            $id_comentario= $comentario['id'];
            $comentarioDTO->setFav($comentario['fav']);
            $comentarioDTO->setUsuario($comentario['username']);
            $comentarioDTO->setComentario($comentario['comentario']);
            $comentarioDTO->setDislike($comentario['dislike']);
            $respuestas =$respuestaRepository->respuestavideoID($id, $id_comentario);
            $resDTO = [];
            foreach ($respuestas as $respuesta){
                $respuestaDTO = new RespuestaDTO();
                $respuestaDTO->setId($respuesta['respuesta_id']);
                $respuestaDTO->setUsuario($respuesta['respuesta_username']);
                $respuestaDTO->setMensaje($respuesta['mensaje']);
                $resDTO[] = $respuestaDTO;

            }

            $comentarioDTO->setRespuesta($resDTO);

            $comentariosDTO[] = $comentarioDTO;
        }

        $videoDTO->setComentarioDTO($comentariosDTO);

        return $this->json($videoDTO, Response::HTTP_OK);
    }

    //videos de tus suscripciones
    #[Route('/suscripcionesDos/{id}', name: 'videossuscripcion2', methods: ['GET'])]
    public function listSuscripcionDos(VideoRepository $videoRepository, Request $request, int $id) :JsonResponse
    {
        $suscripciones = $videoRepository->buscarvideosuscripcion($id);
        dump($suscripciones);
        return  $this->json($suscripciones, Response::HTTP_OK);
    }

    //videos por tematicas
    #[Route('/tematica/{id}', name: 'videostematica', methods: ['GET'])]
    public function listByTematica(VideoRepository $videoRepository, Request $request, int $id)
    {
        $temas = $videoRepository->buscarvideotematica($id);
        dump($temas);
        return $this->json($temas, Response::HTTP_OK);
    }

    //las suscripciones y las sugerencias de tematica juntas
    #[Route('/sugerencias/{idSuscripcion}/{idTematica}', name: 'lista_sugerencias', methods: ['GET'])]
    public function listasugerencias(VideoRepository $videoRepository, Request $request, int $idSuscripcion, int $idTematica): JsonResponse
    {
        $videosSuscripcion = $videoRepository->buscarvideosuscripcion($idSuscripcion);
        $videosTematica = $videoRepository->buscarvideotematica($idTematica);

        $response = [
            'videos_suscripcion' => $videosSuscripcion,
            'videos_tematica' => $videosTematica
        ];

        return $this->json($response, Response::HTTP_OK);
    }

    #[Route('/usuario/{id}', name: 'usuariovideo', methods: ['GET'])]
    public function usuarioVideoId(VideoRepository $videoRepository, Request $request, int $id)
    {
        $usuario = $videoRepository->cogerIdUsuarioVideo($id);
        dump($usuario);
        return $this->json($usuario, Response::HTTP_OK);
    }

    #[Route('/videosSuscripciones/{id}', name: 'videossuscripcion', methods: ['GET'])]
    public function listTodoBySuscripcion (VideoRepository $videoRepository, Request $request, int $id) :JsonResponse
    {
        $suscripciones = $videoRepository->buscarTodosVideosSuscripcion($id);
        dump($suscripciones);
        return $this->json($suscripciones, Response::HTTP_OK);
    }

    #[Route('/listarTitulo', name: 'titulos', methods: ['GET'])]
    public function getTitulo(VideoRepository $videoRepository, Request $request): JsonResponse
    {
        $titulo = $request->query->get('titulo');

        $titulo = $videoRepository->buscarTitulos($titulo);

        dump($titulo);

        return $this->json($titulo, Response::HTTP_OK);
    }

    #[Route('/listarCanales', name: 'canales', methods: ['GET'])]
    public function getCanales(VideoRepository $videoRepository, Request $request): JsonResponse
    {
        $canales = $request->query->get('nombre_canal');

        $canal = $videoRepository->buscarCanal($canales);

        dump($canal);

        return $this->json($canal, Response::HTTP_OK);
    }

    #[Route('/canalId/{id}', name: 'getVideosByIDCanal', methods: ["GET"])]
    public function getVideosByIDCanal(VideoRepository $videoRepository, int $id):JsonResponse
    {
        $videos = $videoRepository -> getVideosByIDCanal($id);
        $listaVideosDTO=[];

        foreach ($videos as $video){
            $videoDTO = new videoDTO();
            $videoDTO ->setId($video['id']);
            $videoDTO ->setTitulo($video['titulo']);
            $videoDTO ->setDescripcion($video['descripcion']);
            $videoDTO ->setUrl($video['url']);
            $videoDTO ->setCanal($video['nombre_canal']);
            $videoDTO->setTematica($video['id_tematica']);

            $listaVideosDTO[]=$videoDTO;
        }

        return $this -> json($listaVideosDTO, Response::HTTP_OK);
    }

    #[Route('/canalNombre/{canal}', name: 'getVideosByNombreCanal', methods: ["GET"])]
    public function getVideosByNombreCanal(VideoRepository $videoRepository, string $canal):JsonResponse
    {
        $videos = $videoRepository -> getVideosByNombreCanal($canal);
        $listaVideosDTO=[];

        foreach ($videos as $video){
            $videoDTO = new videoDTO();
            $videoDTO ->setId($video['id']);
            $videoDTO ->setTitulo($video['titulo']);
            $videoDTO ->setDescripcion($video['descripcion']);
            $videoDTO ->setUrl($video['url']);
            $videoDTO ->setCanal($video['nombre_canal']);
            $videoDTO->setTematica($video['id_tematica']);

            $listaVideosDTO[]=$videoDTO;
        }

        return $this -> json($listaVideosDTO, Response::HTTP_OK);
    }

}
