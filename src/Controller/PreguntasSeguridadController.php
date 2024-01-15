<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PreguntasSeguridadController extends AbstractController
{
    #[Route('/preguntas/seguridad', name: 'app_preguntas_seguridad')]
    public function index(): Response
    {
        return $this->render('preguntas_seguridad/index.html.twig', [
            'controller_name' => 'PreguntasSeguridadController',
        ]);
    }
}
