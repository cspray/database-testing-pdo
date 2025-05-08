<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Unit\Mysql;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\Pdo\Mysql\MysqlConnectionAdapterFactory;
use Cspray\DatabaseTesting\Pdo\Mysql\MysqlPdoDriver;
use Cspray\DatabaseTesting\Pdo\PdoConnectionAdapter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MysqlConnectionAdapterFactory::class)]
final class MysqlConnectionAdapterFactoryTest extends TestCase {

    public function testFactoryCreatesPdoConnectionAdapterWithCorrectPdoDriver() : void {
        $factory = new MysqlConnectionAdapterFactory(
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
        self::assertInstanceOf(MysqlPdoDriver::class, $subject->pdoDriver());
    }

}