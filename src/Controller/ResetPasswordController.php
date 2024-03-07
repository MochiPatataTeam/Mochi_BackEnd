<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

//#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    public function __construct(
        private ResetPasswordHelperInterface $resetPasswordHelper,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Display & process form to request a password reset.
     */
//    #[Route('/api/resetPassword', name: 'app_forgot_password_request')]
//    public function request(Request $request, MailerInterface $mailer, TranslatorInterface $translator): Response
//    {
//        $form = $this->createForm(ResetPasswordRequestFormType::class);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) { //AQUI VA A ENTRAR EN LA SEGUNDA VUELTA
//            return $this->processSendingPasswordResetEmail(
//                $form->get('email')->getData(),
//                $mailer,
//                $translator
//            );
//        }
//
//        return $this->render('reset_password/request.html.twig', [
//            'requestForm' => $form->createView(),
//        ]);
//    }

    #[Route('/api/resetPassword', name: 'app_forgot_password_request')]
    public function request(Request $request, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        $requestData = json_decode($request->getContent(), true); //recibe los datos del frontend

        if (!$requestData || !isset($requestData['email'])) {
            return new JsonResponse(['error' => 'Invalid JSON data'], Response::HTTP_BAD_REQUEST);
        }

        return $this->processSendingPasswordResetEmail( //manda los datos al siguiente metodo
            $requestData['email'],
            $mailer,
            $translator
        );

    }

    /**
     * Confirmation page after a user has requested a password reset.
     */
    #[Route('/check-email', name: 'app_check_email')] //ME VA A MANDAR AQUI SI O SI CUANDO LA SOLICITUD SE HAYA PROCESADO
    public function checkEmail(): Response
    {
        // Generate a fake token if the user does not exist or someone hit this page directly. TRATAR DE ELIMINAR ESTO.
        // This prevents exposing whether or not a user was found with the given email address or not
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        } //HASTA AQUI

        return $this->render('reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */
    #[Route('/reset/{token}', name: 'app_reset_password')] //Cuando el token ya fue generado, se accedio y para cambiar la contraseña. AQUI
    public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, TranslatorInterface $translator, string $token = null): JsonResponse
    {

//        if ($token) {
//            return new JsonResponse(['message' => 'Error 1']);
//        }

//        $token = $this->getTokenFromSession();
//
//        if (null === $token) {
//            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
//        }

        $this->storeTokenInSession($token); //me almacena el token en la sesion para que el token solo se use una vez


        $token = $this->getTokenFromSession(); //recupera el token de la sesión y lo valida con una biblioteca
        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token); //Si el token es válido el usuario asociado con ese token se almacena en la variable $user

        // Si el token es valido, pasa directamente por aqui
        $form = $this->createForm(ChangePasswordFormType::class); //aqui me crea el formulario
        $form->handleRequest($request);


        // A password reset token should be used only once, remove it.
        $this->resetPasswordHelper->removeResetRequest($token);

        // Obtén la nueva contraseña de la solicitud POST de Angular
        $data = json_decode($request->getContent(), true);

        if (!isset($data['newPassword'])) {
            return new JsonResponse(['error' => 'Nueva contraseña no proporcionada'], 400);
        }

        $newPassword = $data['newPassword'];

        // Encode(hash) the plain password, and set it.
        $encodedPassword = $passwordHasher->hashPassword( $user, $newPassword); //aqui me agarra la nueva contraseña que le envio del front y me la codifica

        $user->setPassword($encodedPassword);
        $this->entityManager->flush();

        // The session is cleaned up after the password has been changed.
        $this->cleanSessionAfterReset();

        return new JsonResponse(['message' => 'Sin errores']); //aqui debo hacer que me rediriga a mi inicio de la pag
    }

//    #[Route('/reset/{token}', name: 'app_reset_password')] //Cuando el token ya fue generado, se accedio y para cambiar la contraseña. AQUI
//    public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, TranslatorInterface $translator, string $token = null): JsonResponse
//    {
//        if ($token) { //----------------- Manejo de excepciones -----------------
//            // We store the token in session and remove it from the URL, to avoid the URL being
//            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
//            $this->storeTokenInSession($token);
//
////            return $this->redirectToRoute('app_reset_password');
//            return new JsonResponse(['message' => 'Error 1']);
//        }
//
//        $token = $this->getTokenFromSession();
//        if (null === $token) {
//            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
//        }
//
//        try {
//            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token); //AQUI ME ESTA VALIDANDO EL TOKEN CON LA AYUDA DE UNA BIBLIOTECA
//        } catch (ResetPasswordExceptionInterface $e) {
//            $this->addFlash('reset_password_error', sprintf(
//                '%s - %s',
//                $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE, [], 'ResetPasswordBundle'),
//                $translator->trans($e->getReason(), [], 'ResetPasswordBundle')
//            ));
//
////            return $this->redirectToRoute('app_forgot_password_request');
//            return new JsonResponse(['message' => 'Error 2']);
//        }
//
//        // Si el token es valido, pasa directamente por aqui
//        $form = $this->createForm(ChangePasswordFormType::class); //aqui me crea el formulario
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            // A password reset token should be used only once, remove it.
//            $this->resetPasswordHelper->removeResetRequest($token);
//
//
//
//            // Obtén la nueva contraseña de la solicitud POST de Angular
//            $newPassword = $request->request->get('newPassword');
//
//
//
//
//
//            // Encode(hash) the plain password, and set it.
//            $encodedPassword = $passwordHasher->hashPassword( $user, $newPassword); //aqui me agarra la nueva contraseña que le envio del front y me la codifica
//
//            $user->setPassword($encodedPassword);
//            $this->entityManager->flush();
//
//            // The session is cleaned up after the password has been changed.
//            $this->cleanSessionAfterReset();
//
//            return new JsonResponse(['message' => 'Contraseña actualizada correctamente']); //aqui debo hacer que me rediriga a mi inicio de la pag
//        }
//
////        return $this->render('reset_password/reset.html.twig', [
////            'resetForm' => $form->createView(),
//        return new JsonResponse(['message' => 'Error 3']);
//        // ]
//        // );
//    }

    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer, TranslatorInterface $translator): JsonResponse
    {
        $user = $this->entityManager->getRepository(Usuario::class)->findOneBy([ //me busca que el email coincida con alguno de la bbdd
            'email' => $emailFormData,
        ]);

        if (!$user) { //Comprueba que el usuario fue encontrado en la bbdd
            return $this->redirectToRoute('app_check_email'); //NUNCA TIENE QUE ENTRAR P0R AQUI
        }


        $resetToken = $this->resetPasswordHelper->generateResetToken($user);


        $email = (new TemplatedEmail())
            ->from(new Address('mochitvteam@gmail.com', 'Mochi Team Bot'))
            ->to($user->getEmail())
            ->subject('Restablece tu contraseña')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ])
        ;

        dump($this->getParameter('mailer_dsn'));

//        try {
//            $mailer->send($email);
//            dump('Correo electrónico enviado correctamente.');
//        } catch (\Exception $e) {
//            dump('Error al enviar el correo electrónico:', $e->getMessage());
//        }

        $mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return new JsonResponse(['message' => 'enviado']);
    }
}
