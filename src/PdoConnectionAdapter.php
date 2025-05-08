<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo;

use Closure;
use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapter;
use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\Exception\ConnectionNotEstablished;
use PDO;

final class PdoConnectionAdapter implements ConnectionAdapter {

    private ?PDO $pdo = null;

    private function __construct(
        private readonly Closure $pdoProvider,
        private readonly PdoDriver $pdoDriver,
    ) {}

    public static function fromConnectionAdapterConfig(
        ConnectionAdapterConfig $config,
        PdoDriver $pdoDriver,
        Closure $onConnect = null
    ) : self {
        return new self(
            function() use($config, $pdoDriver, $onConnect) {
                $dsn = $pdoDriver->dsn($config);
                $pdo = new PDO(
                    $dsn,
                    options: [
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
                );

                if ($onConnect !== null) {
                    $onConnect($pdo);
                }

                return $pdo;
            },
            $pdoDriver
        );
    }

    public function pdoDriver() : PdoDriver  {
        return $this->pdoDriver;
    }

    public function establishConnection() : void {
        $this->pdo = ($this->pdoProvider)();
    }

    public function closeConnection() : void {
        $this->validateConnectionEstablished(__METHOD__);
        unset($this->pdo);
        $this->pdo = null;
    }

    public function underlyingConnection() : object {
        $this->validateConnectionEstablished(__METHOD__);
        return $this->pdo;
    }

    public function beginTransaction() : void {
        $this->pdoDriver->beginTransaction($this->pdo);
    }

    public function rollback() : void {
        $this->pdoDriver->rollback($this->pdo);
    }

    public function truncateTable(string $table) : void {
        $this->pdoDriver->truncateTable($this->pdo, $table);
    }

    public function insert(array $fixtures) : void {
        $this->validateConnectionEstablished(__METHOD__);
        foreach ($fixtures as $fixture) {
            foreach ($fixture->records() as $fixtureRecord) {
                $this->pdoDriver->insert($this->pdo, $fixtureRecord);
            }
        }
    }

    public function selectAll(string $name) : array {
        return $this->pdoDriver->selectAll($this->pdo, $name);
    }

    private function validateConnectionEstablished(string $method) : void {
        if ($this->pdo === null) {
            throw ConnectionNotEstablished::fromInvalidInvocationBeforeConnectionEstablished($method);
        }
    }
}