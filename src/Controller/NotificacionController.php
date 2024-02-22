<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notificacion;
use App\Entity\TipoNotificacion;
use App\Entity\Usuario;
use App\Repository\NotificacionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/api/notificacion')]
class NotificacionController extends AbstractController
{
    #[Route('', name: 'lista_notificaciones', methods: ['GET'])]
    public function lista_notificaciones(NotificacionRepository $notificaciónRepository): JsonResponse
    {
        $notificaciones = $notificaciónRepository->findAll();


        return $this->json($notificaciones);

    }
    #[Route('/{idPersona}', name: 'buscar_mensajes_por_receptor', methods: ['GET'])]
    public function getMensajesPorReceptor(int $idPersona, NotificacionRepository $notificaciónRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $notificaciones = $notificaciónRepository->buscarNotificaciones($idPersona);

        dump($notificaciones);

        return $this->json($notificaciones, Response::HTTP_OK);
    }


    #[Route('', name: 'crear_notificacion', methods: ['POST'])]
    public function crear_notificacion (EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nuevaNotificacion = new Notificacion();
        $usuario= $entityManager->getRepository(Usuario::class)->findBy(["id"=>$data['usuario']]);
        $nuevaNotificacion->setUsuario($usuario[0]);
        $tipo =$entityManager->getRepository(TipoNotificacion::class)->findBy(["id"=>$data['tipo']]);
        $nuevaNotificacion->setTipo($tipo[0]);
        $usuarioCreador= $entityManager->getRepository(Usuario::class)->findBy(["id"=>$data['id_creador']]);
        $nuevaNotificacion->setIdCreador($usuarioCreador[0]);

        $entityManager->persist($nuevaNotificacion);
        $entityManager->flush();
        return $this->json(['message' => '¡Nueva notificacion!'], Response::HTTP_CREATED);

    }
    #[Route('/{id}', name: 'editar_notificacion', methods: ['PUT'])]
    public function editar(int $id, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $notificacion = $entityManager->find(Notificacion::class, $id);

        if (!$notificacion) {
            return $this->json(['message' => 'Notificación no encontrada para el ID: ' . $id], Response::HTTP_NOT_FOUND);
        }

        $notificacion->setVisible($data['visible']);
        $notificacion->setUsuario($entityManager->getReference(Usuario::class, $data['id_usuario']));
        $notificacion->setIdCreador($entityManager->getReference(Usuario::class, $data['id_creador']));
        $notificacion->setTipo($entityManager->getReference(TipoNotificacion::class, $data['id_tipo']));

        $entityManager->flush();

        return $this->json(['message' => 'Notificación editada'], 200);
    }

    #[Route('/{id}', name: "delete_notificacion_by_id", methods: ["DELETE"])]
    public function deleteNotificacionById(EntityManagerInterface $entityManager, $id):JsonResponse
    {
        $notificacion = $entityManager->getRepository(Notificacion::class)->find($id);

        $entityManager->remove($notificacion);
        $entityManager->flush();

        return $this->json(['message' => 'Notificacion eliminada'], Response::HTTP_OK);
    }

}
