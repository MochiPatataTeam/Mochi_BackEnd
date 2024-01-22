<?php

namespace App\Controller;

use App\DTOs\PreguntasUsuarioDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PreguntasUsuarioRepository;
use App\Entity\PreguntasUsuario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/preguntauser')]
class PreguntasUsuarioController extends AbstractController
{
    #[Route('', name: 'lista_preguntas_usuario', methods: ['GET'])]
    public function list_preguntas_usuario(PreguntasUsuarioRepository $preguntasUsuarioRepository): JsonResponse
    {
        $listaPreguntasUsuarios = $preguntasUsuarioRepository->findAll();

        $listaPreguntasUsuariosDTO=[];

        foreach ($listaPreguntasUsuarios as $pregunta) {
            $preguntaUsuarioDTO = new PreguntasUsuarioDTO();
            $preguntaUsuarioDTO->setId($pregunta->getId());
            $preguntaUsuarioDTO->setUsuario($pregunta->getUsuario()->getUsername());
            $preguntaUsuarioDTO->setPregunta($pregunta->getPregunta()->getPregunta());
            $preguntaUsuarioDTO->setRespuesta($pregunta->getRespuesta());

            $listaPreguntasUsuariosDTO[]=$preguntaUsuarioDTO;
        }


        return $this->json($listaPreguntasUsuariosDTO, Response::HTTP_OK);
    }
}
