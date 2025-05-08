<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Postgres;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapter;
use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterFactory;
use Cspray\DatabaseTesting\Pdo\PdoConnectionAdapter;

final class PostgresConnectionAdapterFactory implements ConnectionAdapterFactory {

    public function __construct(
        private readonly ConnectionAdapterConfig $config,
    ) {}

    public function createConnectionAdapter() : ConnectionAdapter {
        return PdoConnectionAdapter::fromConnectionAdapterConfig($this->config, new PostgresPdoDriver());
    }
}