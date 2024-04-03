<?php

namespace App\Event\Subscriber;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class TextEditorContentListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'onBeforeEntityPersisted',
            BeforeEntityUpdatedEvent::class => 'onBeforeEntityUpdated',
        ];
    }

    public function onBeforeEntityPersisted(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof Article){
            return;
        }

        if (method_exists($entity, 'getContent')) {
            $content = $entity->getContent();
            $processedContent = $this->processContent($content);
            $entity->setContent($processedContent);
        }
    }

    public function onBeforeEntityUpdated(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof Article){
            return;
        }

        if (method_exists($entity, 'getContent')) {
            $content = $entity->getContent();
            $processedContent = $this->processContent($content);
            $entity->setContent($processedContent);
        }
    }

    private function processContent(string $content): string
    {
        // Wrap <code> tag around content within <pre> tags
        $processedContent = preg_replace_callback(
            '/<pre>(.*?)<\/pre>/s',
            function (array $matches): string {
                return '<pre><code>' . $matches[1] . '</code></pre>';
            },
            $content
        );

        return $processedContent;
    }

}
