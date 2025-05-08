<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Integration;

use Cspray\DatabaseTesting\Internal\ConnectionAdapterTestCase;
use PDO;
use ReflectionObject;

abstract class PdoConnectionAdapterTestCase extends ConnectionAdapterTestCase {

    protected function expectedConnectionType() : string {
        return PDO::class;
    }

    protected function executeSelectSql(string $sql) : array {
        $pdo = $this->connectionAdapter->underlyingConnection();
        self::assertInstanceOf(PDO::class, $pdo);

        $statement = $pdo->query($sql);
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $records;
    }

    protected function executeDeleteSql(string $sql) : void {
        $pdo = $this->connectionAdapter->underlyingConnection();
        self::assertInstanceOf(PDO::class, $pdo);
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $statement->closeCursor();
    }

    protected function assertConnectionClosed() : void {
        $reflection = new ReflectionObject($this->connectionAdapter);
        $reflectionProperty = $reflection->getProperty('pdo');
        self::assertNull($reflectionProperty->getValue($this->connectionAdapter));
    }

    protected function tearDown() : void {
        parent::tearDown();
        $reflection = new ReflectionObject($this->connectionAdapter);
        $reflectionProperty = $reflection->getProperty('pdo');
        $reflectionProperty->setValue($this->connectionAdapter, null);
    }
}