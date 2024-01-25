<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notificación;
use App\Entity\TipoNotificacion;
use App\Entity\Usuario;
use App\Repository\NotificaciónRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/api/notificacion')]
class NotificacionController extends AbstractController
{
    #[Route('', name: 'lista_notificaciones', methods: ['GET'])]
    public function lista_notificaciones(NotificaciónRepository $notificaciónRepository): JsonResponse
    {
        $notificaciones = $notificaciónRepository->findAll();

        return $this->json($notificaciones);


    }
    #[Route('', name: 'crear_notificacion', methods: ['POST'])]
    public function crear_notificacion (EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nuevaNotificacion = new Notificación();
        $usuario= $entityManager->getRepository(Usuario::class)->findBy(["id"=>$data['usuario']]);
        $nuevaNotificacion->setUsuario($usuario[0]);
        $tipo =$entityManager->getRepository(TipoNotificacion::class)->findBy(["id"=>$data['tipo']]);
        $nuevaNotificacion->setTipo($tipo[0]);

        $entityManager->persist($nuevaNotificacion);
        $entityManager->flush();
        return $this->json(['message' => '¡Nueva notificacion!'], Response::HTTP_CREATED);

    }
    #[Route('/{id}', name: "delete_notificacion_by_id", methods: ["DELETE"])]
    public function deleteNotificacionById(EntityManagerInterface $entityManager, $id):JsonResponse
    {
        $notificacion = $entityManager->getRepository(Notificación::class)->find($id);

        $entityManager->remove($notificacion);
        $entityManager->flush();

        return $this->json(['message' => 'Notificacion eliminada'], Response::HTTP_OK);
    }

}
