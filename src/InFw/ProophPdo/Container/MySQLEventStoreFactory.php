<?php

declare(strict_types=1);

namespace InFw\ProophPdo\Container;

use Interop\Container\ContainerInterface;
use PDO;
use Prooph\Common\Event\ActionEventEmitter;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\MySqlEventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy\MySqlAggregateStreamStrategy;

class MySQLEventStoreFactory
{
    public function __invoke(ContainerInterface $container): EventStore
    {
        $pdo = $container->get(PDO::class);

        $eventStore = new MySqlEventStore(new FQCNMessageFactory(), $pdo, new MySqlAggregateStreamStrategy());
        $eventEmitter = $container->get(ActionEventEmitter::class);

        return new ActionEventEmitterEventStore($eventStore, $eventEmitter);
    }
}
