<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SuscripcionRepository;
use App\Entity\Suscripcion;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/api/suscripcion')]
class SuscripcionController extends AbstractController
{
    #[Route('', name: 'lista_suscripciones', methods: ['GET'])]
    public function lista_suscripciones(SuscripcionRepository $suscripcionRepository): JsonResponse
    {
        $suscripciones = $suscripcionRepository->findAll();


        return $this->json($suscripciones);
    }
    #[Route('', name: 'crear_suscripcion', methods: ['POST'])]
    public function crear_suscripcion (EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nuevaSuscripcion = new Suscripcion();
        $suscriptor = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$data['suscriptor']]);
        $nuevaSuscripcion->setSuscriptor($suscriptor[0]);
        $canal = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$data['canal']]);
        $nuevaSuscripcion->setCanal($canal[0]);

        $entityManager->persist($nuevaSuscripcion);
        $entityManager->flush();

        return $this->json(['message' => '¡Gracias por suscribirte!'], Response::HTTP_CREATED);
    }
    #[Route('/{id}', name: "delete_suscripcion_by_id", methods: ["DELETE"])]
    public function deleteById(EntityManagerInterface $entityManager, $id):JsonResponse
    {
        $suscripcion = $entityManager->getRepository(Suscripcion::class)->find($id);

        $entityManager->remove($suscripcion);
        $entityManager->flush();

        return $this->json(['message' => 'Suscripción eliminada'], Response::HTTP_OK);
    }
}
