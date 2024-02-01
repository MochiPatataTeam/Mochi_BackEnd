<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/registro')]
class RegistroController extends AbstractController
{
    #[Route('', name: 'registrar_usuario', methods: ["POST"])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request-> getContent(), true);

        $user = new Usuario();
        $user->setNombre($data['nombre']);
        $user->setApellidos($data['apellidos']);
        $user->setUsername($data['username']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password'])); //aqui estoy guardando la password hasheada
        $user->setEmail($data['email']);
        $user->setTelefono($data['telefono']);
        $user->setNombreCanal($data['nombre_canal']);
        $user->setDescripcion($data['descripcion']);
        //suscriptores(deafult 0-null)
        //imagen


        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Usuario registrado con exito'], 201);
    }
}
