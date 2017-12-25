<?php

declare(strict_types=1);

namespace InFw\ProophPdo\Container;

use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Psr\Container\ContainerInterface;

class ProophCommandBusFactory
{
    public function __invoke(ContainerInterface $container): CommandBus
    {
        $config = $container->get('config')['prooph'];
        $commandBus = new CommandBus();
        $router = new CommandRouter();

        array_walk(
            $config['command_router'],
            function (string $handler, string $command) use ($router, $container) {
                $router->route($command)->to($container->get($handler));
            }
        );

        $router->attachToMessageBus($commandBus);

        return $commandBus;
    }
}
