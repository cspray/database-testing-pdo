<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Unit\Sqlite;

use Cspray\DatabaseTesting\Pdo\PdoConnectionAdapter;
use Cspray\DatabaseTesting\Pdo\Sqlite\SqliteConnectionAdapterFactory;
use Cspray\DatabaseTesting\Pdo\Sqlite\SqlitePdoDriver;
use PDO;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SqliteConnectionAdapterFactory::class)]
final class SqliteConnectionAdapterFactoryTest extends TestCase {

    public function testFactoryCreatesPdoConnectionAdapterWithCorrectPdoDriver() : void {
        $factory = new SqliteConnectionAdapterFactory();
        $subject = $factory->createConnectionAdapter();

        self::assertInstanceOf(PdoConnectionAdapter::class, $subject);
        self::assertInstanceOf(SqlitePdoDriver::class, $subject->pdoDriver());
    }

    public function testFactoryWithoutInitialSchemaPathDoesNotHaveUserCreatedTables() : void {
        $factory = new SqliteConnectionAdapterFactory();
        $subject = $factory->createConnectionAdapter();

        $subject->establishConnection();

        $connection = $subject->underlyingConnection();

        self::assertInstanceOf(PDO::class, $connection);

        $tables = $connection->query(
            "SELECT name FROM sqlite_schema WHERE type = 'table' AND name NOT LIKE 'sqlite_%'"
        )->fetchAll(PDO::FETCH_ASSOC);

        self::assertSame([], $tables);

        $subject->closeConnection();
    }

    public function testFactoryWithInitialSchemaPathDoesHaveUserCreatedTables() : void {
        $factory = new SqliteConnectionAdapterFactory(
            initialSchemaPath: __DIR__ . '/../../../resources/schemas/sqlite.sql'
        );
        $subject = $factory->createConnectionAdapter();

        $subject->establishConnection();

        $connection = $subject->underlyingConnection();

        self::assertInstanceOf(PDO::class, $connection);

        $tables = $connection->query(
            "SELECT name FROM sqlite_schema WHERE type = 'table' AND name NOT LIKE 'sqlite_%'"
        )->fetchAll(PDO::FETCH_ASSOC);

        self::assertSame(['my_table'], array_column($tables, 'name'));

        $subject->closeConnection();
    }
}