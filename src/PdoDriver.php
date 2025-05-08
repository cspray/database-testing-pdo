<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\Fixture\FixtureRecord;
use PDO;

interface PdoDriver {

    public function dsn(ConnectionAdapterConfig $config) : string;

    public function beginTransaction(PDO $pdo) : void;

    public function rollback(PDO $pdo) : void;

    public function truncateTable(PDO $pdo, string $table) : void;

    public function insert(PDO $pdo, FixtureRecord $fixtureRecord) : void;

    public function selectAll(PDO $pdo, string $table) : array;

}
