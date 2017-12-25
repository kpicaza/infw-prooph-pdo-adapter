<?php

declare(strict_types=1);

namespace InFw\ProophPdo;

use InFw\ProophPdo\Container\MySQLEventStoreFactory;
use InFw\ProophPdo\Container\PdoSnapshotStoreFactory;
use InFw\ProophPdo\Container\ProophCommandBusFactory;
use InFw\ProophPdo\Container\ProophEventBusFactory;
use InFw\ProophPdo\Container\ProophEventRouterFactory;
use Prooph\Common\Event\ActionEventEmitter;
use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\Projection\MySqlProjectionManager;
use Prooph\EventStore\Projection\ProjectionManager;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use Prooph\SnapshotStore\SnapshotStore;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'invokables' => [
                    ActionEventEmitter::class => ProophActionEventEmitter::class,
                    ProjectionManager::class => MySqlProjectionManager::class,
                ],
                'factories' => [
                    SnapshotStore::class => PdoSnapshotStoreFactory::class,
                    EventBus::class => ProophEventBusFactory::class,
                    EventStore::class => MySQLEventStoreFactory::class,
                    CommandBus::class => ProophCommandBusFactory::class,
                    EventRouter::class => ProophEventRouterFactory::class,
                ],
            ],
            'prooph' => [
                'command_router' => [
//                    Command::class => InvokableHandler::class,
                ],
                'event_router' => [
//                    Event::class => [
//                        InvokableHandler1::class,
//                        InvokableHandler2::class,
//                    ]
                ]
            ]

        ];
    }
}
