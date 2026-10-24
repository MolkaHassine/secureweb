<?php

namespace App\EventSubscriber;

use App\Entity\LoginAttempt;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class SecurityEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RequestStack $requestStack
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof User) {
            $user->setLastLoginAt(new \DateTimeImmutable());
            $this->entityManager->persist($user);
        }

        $loginAttempt = new LoginAttempt();
        $loginAttempt->setIpAddress($request ? ($request->getClientIp() ?? '127.0.0.1') : '127.0.0.1');
        $loginAttempt->setEmail($user instanceof User ? $user->getEmail() : null);
        $loginAttempt->setSuccessful(true);
        $loginAttempt->setUserAgent($request ? $request->headers->get('User-Agent') : null);

        $this->entityManager->persist($loginAttempt);
        $this->entityManager->flush();
    }
}
