<?php

declare(strict_types=1);

namespace InFw\ProophPdo\Container;

use Prooph\Common\Event\ActionEventEmitter;
use Prooph\EventStore\EventStore;
use Prooph\EventStoreBusBridge\EventPublisher;
use Prooph\ServiceBus\EventBus;
use Psr\Container\ContainerInterface;

class ProophEventBusFactory
{
    public function __invoke(ContainerInterface $container): EventBus
    {
        $eventBus = new EventBus($container->get(ActionEventEmitter::class));
        $eventPublisher = new EventPublisher($eventBus);
        $eventPublisher->attachToEventStore($container->get(EventStore::class));

        return $eventBus;
    }
}
