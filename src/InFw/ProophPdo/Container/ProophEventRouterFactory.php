<?php

declare(strict_types=1);

namespace InFw\ProophPdo\Container;

use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use Psr\Container\ContainerInterface;

class ProophEventRouterFactory
{
    public function __invoke(ContainerInterface $container): EventRouter
    {
        $config = $container->get('config')['prooph'];

        $router = new EventRouter();

        array_walk(
            $config['event_router'],
            /** @var callable[] $handlers */
            function (array $handlers, string $event) use ($router, $container) {
                foreach ($handlers as $handler) {
                    $router->route($event)->to($container->get($handler));
                }
            }
        );

        $router->attachToMessageBus($container->get(EventBus::class));

        return $router;
    }
}
