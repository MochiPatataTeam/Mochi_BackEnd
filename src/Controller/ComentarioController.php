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
}
