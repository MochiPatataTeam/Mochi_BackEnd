<?php

namespace App\Controller;

use App\DTOs\ValoracionDTO;
use App\DTOs\ValoracionGlobalDTO;
use App\Entity\Video;
use App\Entity\Usuario;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ValoracionRepository;
use App\Entity\Valoracion;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
#[Route('/api/valoracion')]
class ValoracionController extends AbstractController
{
#[Route('', name: 'lista_valoraciones', methods: ['GET'])]
public function lista_valoracion(ValoracionRepository $valoracionRepository): JsonResponse
{
    $listaValoraciones = $valoracionRepository->findAll();

    $listaValoracionesDTO = [];

    foreach($listaValoraciones as $valoracion){
        $valoracionDTO = new ValoracionDTO();
        $valoracionDTO->setId($valoracion->getId());
        $valoracionDTO->setFav($valoracion->getFav());
        $valoracionDTO->setDislike($valoracion->getDislike());
        $valoracionDTO->setVisualizacion($valoracion->getVisualizacion());
        $valoracionDTO->setVideo($valoracion->getVideo()->getTitulo());
        $valoracionDTO->setUsuario($valoracion->getUsuario()->getUsername());

        $listaValoracionesDTO[]=$valoracionDTO;
    }
    return $this->json($listaValoracionesDTO, Response::HTTP_OK);
}

#[Route('/valorId/{id}', name: "valoracionGlobalesPorId", methods: ["GET"])]
public function valoracionGlobal(ValoracionRepository $valoracionRepository, int $id): JsonResponse
{
    $visualizacion = $valoracionRepository->visualizacionTotal($id);
    $like = $valoracionRepository->favTotal($id);
    $dislike = $valoracionRepository->dislikeTotal($id);


    $valoraciones = new ValoracionGlobalDTO();
    $valoraciones->setVisualizacion($visualizacion[0]['visualizacion']);
    $valoraciones->setFav($like[0]['fav']);
    $valoraciones->setDislike($dislike[0]['dislike']);


    return $this->json($valoraciones, Response::HTTP_OK);
}

//la llamada en el postman para este metodo con el usuario nulo seria http://localhost:8000/api/valoracion/visual/1 el numero que hay es el id_video, yo le hice pruebas y funciona perfectamente
#[Route('/visual/{id_video}/{id_usuario?}', name: "visualPorId", methods: ["POST"])] //En el route el id_usuario tiene el ? por que el dato puede recibirse en nulo
public function sumavisualizacion(EntityManagerInterface $entityManager, ValoracionRepository $valoracionRepository, int $id_video, ?int $id_usuario = null): JsonResponse //En este caso que es el del dato lo mismo es para que permite el nulo
{

    //Esta es la llamada a la query que ya esta preparada y explicada en el repository que permite nulo el usuario
    $valora = $valoracionRepository->valoracionPorId($id_video, $id_usuario);

    //Si la query no trae resultado se crea y esta preparada para que si el usuario es null se cree como tal
    if(!$valora){
        $nuevaValoracion = new Valoracion();
        $nuevaValoracion->setFav(false);
        $nuevaValoracion->setDislike(false);
        $nuevaValoracion->setVisualizacion(1);
        $video = $entityManager->getRepository(Video::class)->findBy(["id" => $id_video]);
        $nuevaValoracion->setVideo($video[0]);
        if ($id_usuario === null) {
            $nuevaValoracion->setUsuario(null);
        }else{
            $usuario = $entityManager->getRepository(Usuario::class)->findBy(["id" => $id_usuario]);
            $nuevaValoracion->setUsuario($usuario[0]);
        }
        $entityManager->persist($nuevaValoracion);
        $entityManager->flush();
        return $this->json(['message' => 'nueva valoracion creada'], Response::HTTP_OK);
    }
    //Si la query trae resultado esta lo que hace es implementar un update en la visualizacion a +1
    $valoracion = $valora[0];
    $visualizacionActual = $valoracion['visualizacion'];
    $valoracionEntity = $entityManager->getRepository(Valoracion::class)->find($valoracion['id']);
    $valoracionEntity->setVisualizacion($visualizacionActual + 1);
    $entityManager->flush();

    return $this->json(['message' => 'Visualización incrementada'], Response::HTTP_OK);
}

    #[Route('/favorito/{id_video}/{id_usuario}', name: "FavPorId", methods: ["POST"])]
    public function likeporvideo(EntityManagerInterface $entityManager, ValoracionRepository $valoracionRepository, int $id_video, int $id_usuario): JsonResponse
    {

        $valora = $valoracionRepository->valoracionPorId($id_video, $id_usuario);

        //el resultado de la query le implementa un update en el like a true
        $valoracion = $valora[0];
        $favActual = $valoracion['fav'];
        $dislikeActual = $valoracion['dislike'];
        if ($favActual === false){
         $valoracionEntity = $entityManager->getRepository(Valoracion::class)->find($valoracion['id']);
            $valoracionEntity->setFav(true);
            if ($dislikeActual === true){
                $valoracionEntity->setDislike(false);
            }
            $entityManager->flush();
            return $this->json(['message' => 'Buen likesito'], Response::HTTP_OK);
        }else{
            $valoracionEntity = $entityManager->getRepository(Valoracion::class)->find($valoracion['id']);
            $valoracionEntity->setFav(false);
            $entityManager->flush();
            return $this->json(['message' => 'Adios al likesito'], Response::HTTP_OK);
        }

    }


    #[Route('/dislike/{id_video}/{id_usuario}', name: "dislikePorId", methods: ["POST"])]
    public function dislikeporvideo(EntityManagerInterface $entityManager, ValoracionRepository $valoracionRepository, int $id_video, int $id_usuario): JsonResponse
    {

        $valora = $valoracionRepository->valoracionPorId($id_video, $id_usuario);

        //el resultado de la query le implementa un update en el like a true
        $valoracion = $valora[0];
        $likeActual = $valoracion['fav'];
        $dislikeActual = $valoracion['dislike'];
        if ($dislikeActual === false){
            $valoracionEntity = $entityManager->getRepository(Valoracion::class)->find($valoracion['id']);
            $valoracionEntity->setDislike(true);
            if ($likeActual === true){
                $valoracionEntity->setFav(false);
            }
            $entityManager->flush();
            return $this->json(['message' => 'Buen dislikesito'], Response::HTTP_OK);
        }else{
            $valoracionEntity = $entityManager->getRepository(Valoracion::class)->find($valoracion['id']);
            $valoracionEntity->setDislike(false);
            $entityManager->flush();
            return $this->json(['message' => 'Adios al dislikesito'], Response::HTTP_OK);
        }

    }

}
