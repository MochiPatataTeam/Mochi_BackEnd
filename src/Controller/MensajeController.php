<?php

namespace App\Controller;

use App\DTOs\MensajeDTO;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MensajeRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/mensajes')]
class MensajeController extends AbstractController
{
    #[Route('', name: 'app_mensaje', methods: ['GET'])]
    public function listarMensajes(MensajeRepository $mensajeRepository): JsonResponse
    {
        $listMensajes = $mensajeRepository -> findAll();

        $listaMensajesDTO = [];

        foreach ($listMensajes as $mensaje){

            $mensajeDTO = new MensajeDTO();

            $mensajeDTO -> setId($mensaje ->getId());
            $mensajeDTO -> setMensaje($mensaje ->getMensaje());
            $mensajeDTO -> setFecha($mensaje ->getFecha());
            $mensajeDTO -> setIdEmisor($mensaje ->getIdEmisor()->getUsername());
            $mensajeDTO -> setIdReceptor($mensaje ->getIdReceptor()->getUsername());

            $listaMensajesDTO[]= $mensajeDTO;

        }



        return $this->json($listaMensajesDTO, Response::HTTP_OK);
    }
    #[Route('', name: 'crear_mensajes', methods: ['POST'])]
    public function crearMensaje(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $mensaje = new Mensaje();

        $mensaje -> setMensaje($data['mensaje']);
        $mensaje -> setFecha($data['fecha']);
        $mensaje -> setIdEmisor($data['id_emisor']);
        $mensaje -> setIdReceptor($data['id_receptor']);

        $entityManager->persist($mensaje);
        $entityManager->flush();

        return $this->json(['message' => 'Mensaje creado'], Response::HTTP_CREATED);
    }

    #[Route('/{idEmisor}/{idReceptor}', name: 'buscar_mensajes', methods: ['GET'])]
    public function buscarMensajesPorEmisorReceptor(int $idEmisor, int $idReceptor, MensajeRepository $mensajeRepository): JsonResponse
    {
        $mensajes = $mensajeRepository->createQueryBuilder('m')
            ->where('(m.id_emisor = :id_emisor AND m.id_receptor = :id_receptor) OR (m.id_emisor = :id_receptor AND m.id_receptor = :id_emisor)')
            ->setParameter('id_emisor', $idEmisor)
            ->setParameter('id_receptor', $idReceptor)
            ->getQuery()
            ->getResult();

        $listaMensajesDTO = [];

        foreach ($mensajes as $mensaje){

            $mensajeDTO = new MensajeDTO();

            $mensajeDTO -> setId($mensaje ->getId());
            $mensajeDTO -> setMensaje($mensaje ->getMensaje());
            $mensajeDTO -> setFecha($mensaje ->getFecha());
            $mensajeDTO -> setIdEmisor($mensaje ->getIdEmisor()->getId());
            $mensajeDTO -> setIdReceptor($mensaje ->getIdReceptor()->getId());

            $listaMensajesDTO[]= $mensajeDTO;

        }

        return $this->json($listaMensajesDTO, Response::HTTP_OK);
    }
    #[Route('/{idReceptor}', name: 'buscar_mensajes_por_receptor', methods: ['GET'])]
    public function getMensajesPorReceptor(int $idReceptor, MensajeRepository $mensajeRepository, EntityManagerInterface $entityManager): JsonResponse
    {

        $mensajes = $mensajeRepository->createQueryBuilder('m')
            ->select('u.nombre','u.id')
            ->join('m.id_emisor', 'u')
            ->where('m.id_receptor = :id_receptor')
            ->groupBy('u.nombre', 'm.id_emisor','u.id')
            ->setParameter('id_receptor', $idReceptor)
            ->getQuery()
            ->getResult();

        dump($mensajes);



        return $this->json($mensajes, Response::HTTP_OK);
    }
}
