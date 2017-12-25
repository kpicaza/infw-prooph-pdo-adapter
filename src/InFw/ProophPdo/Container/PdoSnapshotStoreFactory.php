<?php

declare(strict_types=1);

namespace InFw\ProophPdo\Container;

use PDO;
use Prooph\SnapshotStore\Pdo\PdoSnapshotStore;
use Prooph\SnapshotStore\SnapshotStore;
use Psr\Container\ContainerInterface;

class PdoSnapshotStoreFactory
{
    public function __invoke(ContainerInterface $container): SnapshotStore
    {
        return new PdoSnapshotStore($container->get(PDO::class));
    }
}
