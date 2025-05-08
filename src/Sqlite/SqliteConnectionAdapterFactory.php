<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Sqlite;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapter;
use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterFactory;
use Cspray\DatabaseTesting\Pdo\PdoConnectionAdapter;
use PDO;

/**
 * @template-implements ConnectionAdapterFactory<PDO>
 */
final class SqliteConnectionAdapterFactory implements ConnectionAdapterFactory {

    public function __construct(
        private readonly string $databasePath = ':memory:',
        private readonly ?string $initialSchemaPath = null,
    ) {}

    public function createConnectionAdapter() : ConnectionAdapter {
        return PdoConnectionAdapter::fromConnectionAdapterConfig(
            new SqliteConnectionAdapterConfig($this->databasePath),
            new SqlitePdoDriver(),
            function(PDO $pdo) : void {
                if ($this->initialSchemaPath !== null) {
                    $statement = $pdo->query(file_get_contents($this->initialSchemaPath));
                    $statement->closeCursor();
                }
            }
        );
    }
}