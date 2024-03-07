<?php

namespace App\Controller;
use App\DTOs\ComentarioDTO;
use App\DTOs\PreguntasUsuarioDTO;
use App\DTOs\PrivacidadUsuarioDTO;
use App\Entity\PrivacidadUsuario;
use App\Entity\Usuario;
use App\Repository\PrivacidadUsuarioRepository;
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

#[Route('/api/privacidad')]
class PrivacidadUsuarioController extends AbstractController
{
    #[Route('', name: 'listaPrivacidad', methods: ['GET'])]
    public function listarPrivacidad(PrivacidadUsuarioRepository $privacidadUsuarioRepository): JsonResponse
    {
        $listaPrivacidad = $privacidadUsuarioRepository->findAll();

        $listaPrivacidadDTO = [];

        foreach ($listaPrivacidad as $privacidadUsuario){
            $privacidadUsuarioDTO = new PrivacidadUsuarioDTO();
            $privacidadUsuarioDTO->setId($privacidadUsuario->getId());
            $privacidadUsuarioDTO->setIsPublico($privacidadUsuario->isIsPublico());
            $privacidadUsuarioDTO->setPermitirSuscripciones($privacidadUsuario->isPermitirSuscripciones());
            $privacidadUsuarioDTO->setPermitirDescargar($privacidadUsuario->isPermitirDescargar());
            $privacidadUsuarioDTO->setUsuario($privacidadUsuario->getUsuario()->getId());

            $listaPrivacidadDTO[] = $privacidadUsuarioDTO;
        }
        return $this->json($listaPrivacidadDTO, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'editarPrivacidad', methods: ['PUT'])] //ESTO AGARRE EL ID DE LA PRIVACIDAD, PERO TENGO Q HACERLO CON ID USUARIO
    public function editarPrivacidad(EntityManagerInterface $entityManager, PrivacidadUsuarioRepository $privacidadUsuarioRepository, Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(), associative: true);

        $privacidadUsuario = $entityManager->getRepository(PrivacidadUsuario::class)->find($id);

        if (!$privacidadUsuario){
            return $this->json(['message' => 'No existe'], Response::HTTP_NOT_FOUND);
        }

        $privacidadUsuario->setIsPublico($data['isPublico']);
        $privacidadUsuario->setPermitirSuscripciones($data['permitirSuscripciones']);
        $privacidadUsuario->setPermitirDescargar($data['permitirDescargar']);

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id" => $data['usuario']]);
        $privacidadUsuario->setUsuario($usuario[0]);

        $entityManager->flush();
        return $this->json(['message' => 'Editado :)'], Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'getByIdUsuario', methods: ["GET"])]
    public function getById(PrivacidadUsuarioRepository $privacidadUsuarioRepository, int $id): JsonResponse
    {
        $privacidadUsuario = $privacidadUsuarioRepository -> getById($id);

        foreach ($privacidadUsuario as $privUsuario){
            $privacidadUsuarioDTO = new PrivacidadUsuarioDTO();
            $privacidadUsuarioDTO->setId($privUsuario['id']);
            $privacidadUsuarioDTO->setIsPublico($privUsuario['is_publico']);
            $privacidadUsuarioDTO->setPermitirSuscripciones($privUsuario['permitir_suscripciones']);
            $privacidadUsuarioDTO->setPermitirDescargar($privUsuario['permitir_descargar']);
            $privacidadUsuarioDTO->setUsuario($privUsuario['id_usuario']);
        }

        return $this -> json($privacidadUsuarioDTO, Response::HTTP_OK);
    }

    #[Route('/canal/{canal}', name: 'getByUsuarioCanal', methods: ["GET"])]
    public function getByCanal(PrivacidadUsuarioRepository $privacidadUsuarioRepository,string $canal): JsonResponse
    {
        $privacidadUsuario = $privacidadUsuarioRepository -> getByCanal($canal);

        foreach ($privacidadUsuario as $privUsuario){
            $privacidadUsuarioDTO = new PrivacidadUsuarioDTO();
            $privacidadUsuarioDTO->setId($privUsuario['id']);
            $privacidadUsuarioDTO->setIsPublico($privUsuario['is_publico']);
            $privacidadUsuarioDTO->setPermitirSuscripciones($privUsuario['permitir_suscripciones']);
            $privacidadUsuarioDTO->setPermitirDescargar($privUsuario['permitir_descargar']);
            $privacidadUsuarioDTO->setUsuario($privUsuario['id_usuario']);
        }

        return $this -> json($privacidadUsuarioDTO, Response::HTTP_OK);
    }

}