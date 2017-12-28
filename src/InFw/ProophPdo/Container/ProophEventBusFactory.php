<?php

declare(strict_types=1);

namespace InFw\ProophPdo\Container;

use Prooph\Common\Event\ActionEventEmitter;
use Prooph\EventStore\EventStore;
use Prooph\EventStoreBusBridge\EventPublisher;
use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use Psr\Container\ContainerInterface;

class ProophEventBusFactory
{
    public function __invoke(ContainerInterface $container): EventBus
    {
        $config = $container->get('config')['prooph'];

        $router = new EventRouter();

        $eventBus = new EventBus($container->get(ActionEventEmitter::class));
        $eventPublisher = new EventPublisher($eventBus);
        $eventPublisher->attachToEventStore($container->get(EventStore::class));

        array_walk(
            $config['event_router'],
            /** @var callable[] $handlers */
            function (array $handlers, string $event) use ($router, $container) {
                foreach ($handlers as $handler) {
                    $router->route($event)->to($container->get($handler));
                }
            }
        );

        $router->attachToMessageBus($eventBus);

        return $eventBus;
    }
}
