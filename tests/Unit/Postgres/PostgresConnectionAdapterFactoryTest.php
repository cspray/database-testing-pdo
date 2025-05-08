<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Unit\Postgres;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\Pdo\Mysql\MysqlConnectionAdapterFactory;
use Cspray\DatabaseTesting\Pdo\Mysql\MysqlPdoDriver;
use Cspray\DatabaseTesting\Pdo\PdoConnectionAdapter;
use Cspray\DatabaseTesting\Pdo\Postgres\PostgresConnectionAdapterFactory;
use Cspray\DatabaseTesting\Pdo\Postgres\PostgresPdoDriver;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostgresConnectionAdapterFactory::class)]
final class PostgresConnectionAdapterFactoryTest extends TestCase {

    public function testFactoryCreatesPdoConnectionAdapterWithCorrectPdoDriver() : void {
        $factory = new PostgresConnectionAdapterFactory(
            new ConnectionAdapterConfig(
                'database',
                'host',
                0,
                'user',
                'password'
            )
        );

        $subject = $factory->createConnectionAdapter();

        self::assertInstanceOf(PdoConnectionAdapter::class, $subject);
        self::assertInstanceOf(PostgresPdoDriver::class, $subject->pdoDriver());
    }

}