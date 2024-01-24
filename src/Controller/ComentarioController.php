<?php

namespace App\Controller;
use App\DTOs\ComentarioDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ComentarioRepository;
use App\Entity\Comentario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/comentario')]
class ComentarioController extends AbstractController
{
    #[Route('', name: 'lista_comentarios', methods: ['GET'])]
    public function lista_comentario(ComentarioRepository $comentarioRepository): JsonResponse
    {
        $listaComentarios = $comentarioRepository->findAll();

        $listaComentariosDTO = [];

        foreach ($listaComentarios as $comentario){
            $comentarioDTO = new ComentarioDTO();
            $comentarioDTO->setId($comentario->getId());
            $comentarioDTO->setFav($comentario->isFav());
            $comentarioDTO->setDislike($comentario->isDislike());
            $comentarioDTO->setUsuario($comentario->getUsuario()->getUsername());
            $comentarioDTO->setVideo($comentario->getVideo()->getTitulo());
            $comentarioDTO->setComentario($comentario->getComentario());

            $listaComentariosDTO[]=$comentarioDTO;
        }
        return $this->json($listaComentariosDTO, Response::HTTP_OK);
    }

    #[Route('', name: 'crear_comentario', methods: ['POST'])]
    public function crear(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $json = json_decode($request -> getContent(), true);

        $nuevoComentario = new Comentario();
        //Like
        //Dislike
        //Usuario(come from FrontEnd)
        //Video(come from FrontEnd)
        $nuevoComentario->setComentario($json["comentario"]);

        $entityManager->persist($nuevoComentario);
        $entityManager->flush();

        return $this->json(['message' => 'Comentario creado'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'editar_comentario', methods: ['PUT'])]
    public function editar(EntityManagerInterface $entityManager, Request $request, comentario $comentario): JsonResponse
    {
        $json = json_decode($request -> getContent(), true);

        //Like
        //Dislike
        $comentario->setComentario($json["comentario"]);

        $entityManager->persist($comentario);
        $entityManager->flush();

        return $this->json(['message' => 'Comentario editado'], Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'eliminar_comentario_id', methods: ['DELETE'])]
    public function deleteById(EntityManagerInterface $entityManager, comentario $comentario): JsonResponse
    {

        $entityManager->remove($comentario);
        $entityManager->flush();

        return $this->json(['message' => 'Comentario eliminado'], Response::HTTP_OK);
    }
}
