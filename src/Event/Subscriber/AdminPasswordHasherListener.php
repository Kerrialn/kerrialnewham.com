<?php

namespace App\Event\Subscriber;

use App\Entity\Admin;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsDoctrineListener(event:  Events::preUpdate)]
#[AsDoctrineListener(event:  Events::prePersist)]
class AdminPasswordHasherListener
{


    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->hashPassword($event);
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $this->hashPassword($event);
    }

    private function hashPassword(PrePersistEventArgs|PreUpdateEventArgs $event) : void
    {
        $entity = $event->getObject();
        if(!$entity instanceof Admin){
            return;
        }

        $password = $this->userPasswordHasher->hashPassword(user: $entity, plainPassword: $entity->getPassword());
        $entity->setPassword($password);
    }

}
