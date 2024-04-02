<?php

namespace App\Event\Subscriber;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[AsDoctrineListener(event:  Events::preUpdate)]
#[AsDoctrineListener(event:  Events::prePersist)]
class ArticleSlugListener
{

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->updateSlug($event);
    }

    public function prePersit(PrePersistEventArgs $event): void
    {
        $this->updateSlug($event);
    }

    private function updateSlug(PrePersistEventArgs|PreUpdateEventArgs $event) : void
    {
        $entity = $event->getObject();
        if(!$entity instanceof Article){
            return;
        }

        $slugger = new AsciiSlugger();
        $entity->setSlug($slugger->slug(strtolower($entity->getTitle())));
        $event->getObjectManager()->persist($entity);
    }

}
