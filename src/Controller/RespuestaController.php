<?php

namespace App\Controller;

use App\DTOs\RespuestaDTO;
use App\Entity\Comentario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RespuestaRepository;
use App\Entity\Respuesta;
use App\Entity\Usuario;
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

        foreach ($listaRespuestas as $respuesta) {
            $respuestaDTO = new RespuestaDTO();
            $respuestaDTO->setId($respuesta->getId());
            $respuestaDTO->setComentario($respuesta->getComentario()->getComentario());
            $respuestaDTO->setMensaje($respuesta->getMensaje());
            $respuestaDTO->setUsuario($respuesta->getUsuario()->getUsername());


            $listaRespuestasDTO[] = $respuestaDTO;
        }
        return $this->json($listaRespuestasDTO, Response::HTTP_OK);
    }
    //crear
    #[Route('', name: 'crear_respuesta', methods: ['POST'])]
    public function crear_respuesta (EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nuevaRespuesta = new Respuesta();
        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$data['usuario']]);
        $nuevaRespuesta ->setUsuario($usuario[0]);
        $comentario = $entityManager->getRepository(Comentario::class)->findBy(["id"=>$data['comentario']]);
        $nuevaRespuesta -> setComentario($comentario[0]);
        $nuevaRespuesta->setMensaje($data['mensaje']);


        $entityManager->persist($nuevaRespuesta);
        $entityManager->flush();

        return $this->json(['message' => 'Respuesta creada'], Response::HTTP_CREATED);
    }

    //editar respuesta
    #[Route('/{id}', name: 'update_respuesta', methods: ['PUT'])]
    public function editarrespuesta(EntityManagerInterface $entityManager, Request $request, $id) :JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $respuesta = $entityManager->getRepository(Respuesta::class)->find($id);
        if (!$respuesta) {
            return $this->json(['message' => 'Respuesta no encontrada'], Response::HTTP_NOT_FOUND);
        }
        $comentario = $entityManager->getRepository(Comentario::class)->findBy(["id" => $data['comentario']]);
        $respuesta->setComentario($comentario[0]);
        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id" => $data['usuario']]);
        $respuesta->setUsuario($usuario[0]);
        $respuesta ->setMensaje($data['mensaje']);

        $entityManager->flush();

        return $this->json(['message' => 'Respuesta modificada'], Response::HTTP_OK);

    }

    //borrar
    #[Route('/{id}', name: "delete_respuesta_by_id", methods: ["DELETE"])]
    public function deleteRespuestaById(EntityManagerInterface $entityManager, $id):JsonResponse
    {
        $respuesta = $entityManager->getRepository(Respuesta::class)->find($id);

        $entityManager->remove($respuesta);
        $entityManager->flush();

        return $this->json(['message' => 'Respuesta eliminada'], Response::HTTP_OK);

    }


}