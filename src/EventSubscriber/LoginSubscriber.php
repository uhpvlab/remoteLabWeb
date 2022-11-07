<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    public function __construct(private EntityManagerInterface $em, private RequestStack $requestStack)
    {
    }

    public function onInteractiveLoginEvent(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();

        if (($user instanceof User) && $this->requestStack->getMainRequest()->hasSession()) {
            $user->setLastLogin(new \DateTime('now'));
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            InteractiveLoginEvent::class => 'onInteractiveLoginEvent',
        ];
    }
}
