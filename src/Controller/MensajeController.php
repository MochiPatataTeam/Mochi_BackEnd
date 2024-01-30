<?php

namespace App\Controller;

use App\DTOs\MensajeDTO;
use App\Entity\Mensaje;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MensajeRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/mensajes')]
class MensajeController extends AbstractController
{
    #[Route('', name: 'app_mensaje', methods: ['GET'])]
    public function listarMensajes(MensajeRepository $mensajeRepository): JsonResponse
    {
        $listMensajes = $mensajeRepository -> findAll();

        return $this->json($listMensajes, Response::HTTP_OK);
    }
    #[Route('', name: 'crear_mensajes', methods: ['POST'])]
    public function crearMensaje(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuarioRepository = $entityManager->getRepository(Usuario::class);
        $idEmisor = $usuarioRepository->find($data['id_emisor']);
        $idReceptor = $usuarioRepository->find($data['id_receptor']);

        $mensaje = new Mensaje();

        $mensaje -> setMensaje($data['mensaje']);
        $mensaje -> setFecha($data['fecha']);
        $mensaje -> setIdEmisor($idEmisor);
        $mensaje -> setIdReceptor($idReceptor);

        $entityManager->persist($mensaje);
        $entityManager->flush();

        return $this->json(['message' => 'Mensaje creado'], Response::HTTP_CREATED);
    }

    #[Route('/{idEmisor}/{idReceptor}', name: 'buscar_mensajes', methods: ['GET'])]
    public function buscarMensajesPorEmisorReceptor(int $idEmisor, int $idReceptor, MensajeRepository $mensajeRepository): JsonResponse
    {
        $mensajes = $mensajeRepository->buscarMensajes($idEmisor, $idReceptor);

        $listaMensajesDTO = [];

        foreach ($mensajes as $mensaje) {
            $mensajeDTO = new MensajeDTO();

            $mensajeDTO->setId($mensaje->getId());
            $mensajeDTO->setMensaje($mensaje->getMensaje());
            $mensajeDTO->setFecha($mensaje->getFecha());
            $mensajeDTO->setIdEmisor($mensaje->getIdEmisor()->getId());
            $mensajeDTO->setIdReceptor($mensaje->getIdReceptor()->getId());

            $listaMensajesDTO[] = $mensajeDTO;
        }

        return $this->json($listaMensajesDTO, Response::HTTP_OK);
    }
    #[Route('/{idReceptor}', name: 'buscar_mensajes_por_receptor', methods: ['GET'])]
    public function getMensajesPorReceptor(int $idReceptor, MensajeRepository $mensajeRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $mensajes = $mensajeRepository->buscarContactos($idReceptor);

        dump($mensajes);

        return $this->json($mensajes, Response::HTTP_OK);
    }
}
