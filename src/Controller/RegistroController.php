<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

#[Route('api/registro')]
class RegistroController extends AbstractController
{
    #[Route('', name: 'registrar_usuario', methods: ["POST"])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, VerifyEmailHelperInterface $verifyEmailHelper, MailerInterface $mailer): JsonResponse
    {

        try {
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

            $signatureComponents = $verifyEmailHelper->generateSignature(
                'verify_email',
                $user->getId(),
                $user->getEmail(),
                ['id' => $user->getId()]
            );

            // Envío del correo electrónico
            $emailVerify = (new TemplatedEmail())
                ->from(new Address('mochitvteam@gmail.com', 'Mochi Team Bot'))
                ->to($user->getEmail())
                ->subject('Confirma tu cuenta')
                ->htmlTemplate('verify/verify_email.html.twig')
                ->context([
                    'signedUrl' => $signatureComponents->getSignedUrl(),
                    'expiresAt' => $signatureComponents->getExpiresAt(),
                ]);


            dump($this->getParameter('mailer_dsn'));
            $mailer->send($emailVerify);

            return new JsonResponse(['message' => 'Usuario registrado con exito. Verifica tu correo electronico'], 201);
        } catch (AccessDeniedException $e){
            return new JsonResponse(['error' => 'Cuenta sin verificar', 'redirectUrl' =>'http://localhost:4200/error'], 403);
        }
    }

    #[Route('/verify', name: 'verify_email')]
    public function verifyUserEmail(Request $request,VerifyEmailHelperInterface $verifyEmailHelper, UsuarioRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {

        $user = $userRepository ->find($request->query->get('id')); //buscamos el usuario al que pertenece este enlace de confirmación
        if (!$user) { //Si no se encuentra lanzamos un 404
            throw $this->createNotFoundException();
        }

        try { //Para asegurarnos que la url no ha sido manipulada
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail(),
            );
        } catch (VerifyEmailExceptionInterface $e){
            $this->addFlash('error', $e->getReason());
            return new JsonResponse(['message' => 'Error en el try catch']);
        }
        $user->setIsVerified(true);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Cuenta verificada'], 201);
    }

}
