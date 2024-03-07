<?php

namespace App\Controller;
use App\DTOs\ComentarioDTO;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ComentarioRepository;
use App\Repository\RespuestaRepository;
use App\Entity\Respuesta;
use App\Entity\Video;
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

        foreach ($listaComentarios as $comentario) {
            $comentarioDTO = new ComentarioDTO();
            $comentarioDTO->setId($comentario->getId());
            $comentarioDTO->setFav($comentario->isFav());
            $comentarioDTO->setDislike($comentario->isDislike());
            $comentarioDTO->setUsuario($comentario->getUsuario()->getUsername());
            $comentarioDTO->setVideo($comentario->getVideo()->getTitulo());
            $comentarioDTO->setComentario($comentario->getComentario());

            $listaComentariosDTO[] = $comentarioDTO;
        }
        return $this->json($listaComentariosDTO, Response::HTTP_OK);
    }

    #[Route('', name: 'crear_comentario', methods: ['POST'])]
    public function crear(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nuevoComentario = new Comentario();
        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id" => $data['usuario']]);
        $nuevoComentario->setUsuario($usuario[0]);
        $video = $entityManager->getRepository(Video::class)->findBy(["id" => $data['video']['id']]);
        $nuevoComentario->setVideo($video[0]);
        $nuevoComentario->setComentario($data["comentario"]);

        $entityManager->persist($nuevoComentario);
        $entityManager->flush();

        return $this->json(['message' => 'Comentario creado'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'editar_comentario', methods: ['PUT'])]
    public function editar(EntityManagerInterface $entityManager, Request $request, comentario $comentario): JsonResponse
    {
        $json = json_decode($request->getContent(), true);

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

    #[Route('/{id}', name: 'buscar_respuestas', methods: ['GET'])]
    public function getRespuestasPorComentario($id, RespuestaRepository $respuestaRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $respuestas = $respuestaRepository->createQueryBuilder('r')
            ->select('c.id as comentario_id', 'c.fav', 'c.dislike','c.comentario', 'u.username as username_respuesta' ,'r.mensaje')
            ->join('r.comentario', 'c')
            ->join('r.usuario', 'u')
            ->where('c.id = :id_comentario')
            ->setParameter('id_comentario', $id)
            ->getQuery()
            ->getResult();

        dump($respuestas);
        return $this->json($respuestas, Response::HTTP_OK);


    }
    //
}