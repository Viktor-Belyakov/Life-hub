<?php

namespace App\Event\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: AuthenticationSuccessEvent::class)]
class JwtCreatedListener
{
    public function __invoke(JWTCreatedEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        $data['id'] = $user->getId();
        $data['name'] = $user->getName();
        $data['surname'] = $user->getSurname();
        $data['middle_name'] = $user->getMiddleName();
        $data['phone'] = $user->getPhone();
        $data['email'] = $user->getEmail();

        $event->setData($data);
    }
}
