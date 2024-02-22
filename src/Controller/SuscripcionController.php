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
    #[Route('/sub/{id_suscriptor}/{id_canal}', name: 'crear_suscripcion', methods: ['POST'])]
    public function crear_suscripcion (EntityManagerInterface $entityManager, SuscripcionRepository $suscripcionRepository,int $id_suscriptor, int $id_canal ): JsonResponse
    {
        $sub= $suscripcionRepository->suscripcionid($id_suscriptor,$id_canal);

        if (!$sub){
            $nuevaSuscripcion = new Suscripcion();
            $suscriptor = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$id_suscriptor]);
            $nuevaSuscripcion->setSuscriptor($suscriptor[0]);
            $canal = $entityManager->getRepository(Usuario::class)->findBy(["id"=>$id_canal]);
            $nuevaSuscripcion->setCanal($canal[0]);
            $nuevaSuscripcion->setSub(true);

            $entityManager->persist($nuevaSuscripcion);
            $entityManager->flush();

            $suscriptores = $suscripcionRepository->suscripciontotal($id_canal);
            $canal = $entityManager->getRepository(Usuario::class)->find($id_canal);
            $canal->setSuscriptores($suscriptores[0]['total_subs']);
            $entityManager->flush();


            return $this->json(['message' => '¡Gracias por suscribirte por primera vez!', 'prueba' => true], Response::HTTP_CREATED);
        }

        $subs = $sub[0];
        $subActual = $subs['sub'];
        if ($subActual === true){
            $subEntity = $entityManager->getRepository(Suscripcion::class)->find($subs['id']);
            $subEntity->setSub(false);
            $entityManager->flush();
            $suscriptores = $suscripcionRepository->suscripciontotal($id_canal);
            $canal = $entityManager->getRepository(Usuario::class)->find($id_canal);
            $canal->setSuscriptores($suscriptores[0]['total_subs']);
            $entityManager->flush();

            return $this->json(['message' => 'Te has desuscrito perfectamente', 'prueba' => false],Response::HTTP_CREATED);

        }else{
            $subEntity = $entityManager->getRepository(Suscripcion::class)->find($subs['id']);
            $subEntity->setSub(true);
            $entityManager->flush();
            $suscriptores = $suscripcionRepository->suscripciontotal($id_canal);
            $canal = $entityManager->getRepository(Usuario::class)->find($id_canal);
            $canal->setSuscriptores($suscriptores[0]['total_subs']);
            $entityManager->flush();
            return $this->json(['message' => '¡Gracias por suscribirte!', 'prueba' => true], Response::HTTP_CREATED);
        }
    }
    #[Route('/subs', name: 'subs', methods: ['GET'])]
    public function getContactos(SuscripcionRepository $suscripcionRepository, Request $request): JsonResponse
    {
        $id = $request->query->get('id_canal');

        $subs = $suscripcionRepository->buscarSubs($id);

        dump($subs);

        return $this->json($subs, Response::HTTP_OK);
    }
    #[Route('/comprobar/{id_suscriptor}/{id_canal}', name: 'comprobar_suscripcion', methods: ['GET'])]
    public function comprobarsub(SuscripcionRepository $suscripcionRepository,int $id_suscriptor, int $id_canal): JsonResponse
    {
        $sub= $suscripcionRepository->suscripcionid($id_suscriptor,$id_canal);

        if (!$sub){
            return $this->json(['prueba' => false], Response::HTTP_CREATED);
        }
        $subs = $sub[0];
        $subActual = $subs['sub'];
        if ($subActual === true){
            return $this->json(['prueba' => true], Response::HTTP_CREATED);
        }else{
            return $this->json(['prueba' => false], Response::HTTP_CREATED);
        }

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
