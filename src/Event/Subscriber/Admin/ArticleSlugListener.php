<?php

namespace App\Event\Subscriber\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ArticleSlugListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['updateSlug'],
            BeforeEntityUpdatedEvent::class => ['updateSlug'],
        ];
    }

    public function updateSlug(BeforeEntityUpdatedEvent|BeforeEntityPersistedEvent $event) : void
    {
        $entity = $event->getEntityInstance();
        if(!$entity instanceof Article){
            return;
        }

        $slugger = new AsciiSlugger();
        $entity->setSlug($slugger->slug(strtolower($entity->getTitle())));
    }
}
