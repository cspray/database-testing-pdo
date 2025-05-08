<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Sqlite;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;

final class SqliteConnectionAdapterConfig extends ConnectionAdapterConfig {

    public function __construct(
        string $databasePath,
    ) {
        parent::__construct(
            $databasePath,
            '',
            0,
            '',
            ''
        );
    }

}