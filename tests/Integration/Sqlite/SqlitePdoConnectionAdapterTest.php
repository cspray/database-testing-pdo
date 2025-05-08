<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Integration\Sqlite;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapter;
use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\Pdo\Integration\PdoConnectionAdapterTestCase;
use Cspray\DatabaseTesting\Pdo\PdoConnectionAdapter;
use Cspray\DatabaseTesting\Pdo\Sqlite\SqliteConnectionAdapterConfig;
use Cspray\DatabaseTesting\Pdo\Sqlite\SqlitePdoDriver;
use PDO;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PdoConnectionAdapter::class)]
#[CoversClass(SqlitePdoDriver::class)]
final class SqlitePdoConnectionAdapterTest extends PdoConnectionAdapterTestCase {

    protected function connectionAdapter() : ConnectionAdapter {
        return PdoConnectionAdapter::fromConnectionAdapterConfig(
            new SqliteConnectionAdapterConfig(':memory:'),
            new SqlitePdoDriver(),
            function(PDO $pdo) : void {
                $statement = $pdo->query(
                    file_get_contents(__DIR__ . '/../../../resources/schemas/sqlite.sql')
                );
                $statement->closeCursor();
            }
        );
    }

}