<?php

namespace App\Event\Subscriber\Admin;

use App\Entity\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminPasswordHasherListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['hashPassword'],
            BeforeEntityUpdatedEvent::class => ['hashPassword'],
        ];
    }

    public function hashPassword(BeforeEntityPersistedEvent|BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (! ($entity instanceof Admin)) {
            return;
        }

        $password = $this->userPasswordHasher->hashPassword(user: $entity, plainPassword: $entity->getPassword());
        $entity->setPassword($password);
    }
}
