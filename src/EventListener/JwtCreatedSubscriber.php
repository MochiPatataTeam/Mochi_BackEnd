<?php

namespace App\EventListener;

use App\Entity\Usuario;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

class JwtCreatedSubscriber
{
    private $logger;
    private $router;

    public function __construct(LoggerInterface $logger, RouterInterface $router)
    {
        $this->logger = $logger;
        $this->router = $router;
    }

    public function on_jwt_created(JWTCreatedEvent $event)
    {
        $this->logger->debug('JwtCreatedSubscriber: on_jwt_created is being executed.');

        $user = $event->getUser(); //Obtener usuario

        if (!$user instanceof UserInterface){
            return;
        }

        if (!$user->isVerified()){
            throw new AccessDeniedException('Cuenta sin verificar');
//            $event->getData()['redirectUrl'] = 'http://localhost:4200/error';
        }

        $data = $event->getData(); //obtener los datos del token
        $data['id'] = $user->getId(); //al token le añado el id del usuario
        $event->setData($data);
    }
}