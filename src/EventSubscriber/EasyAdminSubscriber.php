<?php

namespace App\EventSubscriber;

use App\Entity\Booking;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatableMessage;

class EasyAdminSubscriber implements EventSubscriberInterface
{


    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private UserRepository $userRepository,
        private ManagerRegistry $registry,
        private UserPasswordHasherInterface $passwordHasher,
        private RequestStack $requestStack,
    )
    {
    }

    /**
     * @return \string[][]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => [
                ['setUserDataOnBookingForm'],
            ],
//            BeforeEntityUpdatedEvent::class => [
//                ['encodeUserPasswords'],
//                ['setClientDataOnBookingForm']
//            ],
//            BeforeCrudActionEvent::class => [
//                ['SetUserDataOnBookingBeforeCrudAction']
//            ],
            AfterEntityPersistedEvent::class => ['flashMessageAfterPersist'],
            AfterEntityUpdatedEvent::class => ['flashMessageAfterUpdate'],
            AfterEntityDeletedEvent::class => ['flashMessageAfterDelete'],
        ];
    }


    public function encodeUserPasswords(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if ($entity instanceof User && $entity->getPlainPassword()!== null) {
            $entity->setPassword($this->passwordHasher->hashPassword($entity, $entity->getPlainPassword()));
        }
    }


    public function flashMessageAfterPersist(AfterEntityPersistedEvent $event): void
    {
        $this->requestStack->getSession()->getFlashBag()->add('success', new TranslatableMessage('content_admin.flash_message.create', [
            '%name%' => (string) $event->getEntityInstance(),
        ], 'admin'));
    }

    public function flashMessageAfterUpdate(AfterEntityUpdatedEvent $event): void
    {
        $this->requestStack->getSession()->getFlashBag()->add('success', new TranslatableMessage('content_admin.flash_message.update', [
            '%name%' => (string) $event->getEntityInstance(),
        ], 'admin'));
    }

    public function flashMessageAfterDelete(AfterEntityDeletedEvent $event): void
    {
        $this->requestStack->getSession()->getFlashBag()->add('success', new TranslatableMessage('content_admin.flash_message.delete', [
            '%name%' => (string) $event->getEntityInstance(),
        ], 'admin'));
    }

    public function setUserDataOnBookingForm(BeforeEntityPersistedEvent|BeforeEntityUpdatedEvent $event){

        $entity = $event->getEntityInstance();

        if (!($entity instanceof Booking)) {
            return;
        }


        if($this->tokenStorage->getToken()->getUser() instanceof  User)
        {
            $user = $this->tokenStorage->getToken()->getUser();
            if($user instanceof User)
            {
                $entity->setUser($user);
            }
            else {
                throw new \Exception('Not user detected on request');
            }

        }

    }


    public function SetUserDataOnBookingBeforeCrudAction(BeforeCrudActionEvent $event)
    {

        if($event->getAdminContext()->getEntity()->getFqcn() !== Booking::class) {
            return;
        }

        // Get the client data from request, find it in db or create a new one, and last...
        // add the client object to the booking one

        $request = $event->getAdminContext()->getRequest()->request->all();

        $booking = $request['Booking'] ?? null;

        if($booking === null)
        {
            return;
        }

        $clientDetails = $booking['clientDetails'] ?? null;
        if(is_array($clientDetails))
        {
            $client = $this->clientRepository->findOneBy(
                [
                    'name' => $clientDetails['name'],
                    'email'=> $clientDetails['email']
                ]);
            if($client === null){
                $client = new Client(
                    $clientDetails['email'],
                    $clientDetails['name'],
                    $clientDetails['telephone'],
                    $clientDetails['locale']
                );
                $this->clientRepository->save($client);
            }
            $booking['client_id'] = $client->getId();
            $request['Booking'] = $booking;

            $event->getAdminContext()->getRequest()->request->replace($request);

        }
    }}
