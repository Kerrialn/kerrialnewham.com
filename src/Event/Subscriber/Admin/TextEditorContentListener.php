<?php

namespace App\Event\Subscriber\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TextEditorContentListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['processContent'],
            BeforeEntityUpdatedEvent::class => ['processContent'],
        ];
    }

    public function processContent(BeforeEntityUpdatedEvent|BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        if (!$entity instanceof Article) {
            return;
        }

        $processedContent = preg_replace_callback(
            '/<pre>(.*?)<\/pre>/s',
            function (array $matches): string {
                return '<pre><code>' . $matches[1] . '</code></pre>';
            },
            $entity->getContent()
        );

        $entity->setContent($processedContent);
    }
}
