<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Mysql;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\Pdo\GenericSqlPdoDriver;
use Cspray\DatabaseTesting\Pdo\PdoDriver;
use PDO;

final class MysqlPdoDriver extends GenericSqlPdoDriver implements PdoDriver {

    public function dsn(ConnectionAdapterConfig $config) : string {
        return sprintf(
            'mysql:host=%s;port=%d;dbname=%s;user=%s;password=%s',
            $config->host,
            $config->port,
            $config->database,
            $config->user,
            $config->password
        );
    }

    public function truncateTable(PDO $pdo, string $table) : void {
        $pdo->query(sprintf('TRUNCATE TABLE %s', $table))->execute();
    }
}