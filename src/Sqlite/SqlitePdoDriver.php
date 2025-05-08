<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Sqlite;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\Pdo\GenericSqlPdoDriver;
use Cspray\DatabaseTesting\Pdo\PdoDriver;
use PDO;

final class SqlitePdoDriver extends GenericSqlPdoDriver implements PdoDriver {

    public function dsn(ConnectionAdapterConfig $config) : string {
        return sprintf('sqlite:%s', $config->database);
    }

    public function beginTransaction(PDO $pdo) : void {
        $pdo->query('BEGIN TRANSACTION');
    }
}