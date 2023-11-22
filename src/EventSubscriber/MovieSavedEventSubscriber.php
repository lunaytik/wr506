<?php

namespace App\EventSubscriber;

use App\Entity\Movie;
use App\Event\MovieSavedEvent;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class MovieSavedEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $movie = $args->getObject();

        if ($movie instanceof Movie) {
            $event = new MovieSavedEvent($movie);
            $args->getObjectManager()->getEventManager()->dispatchEvent($event);
        }
    }
}
