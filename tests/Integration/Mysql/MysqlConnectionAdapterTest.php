<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Integration\Mysql;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapter;
use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\Pdo\Integration\PdoConnectionAdapterTestCase;
use Cspray\DatabaseTesting\Pdo\Mysql\MysqlPdoDriver;
use Cspray\DatabaseTesting\Pdo\PdoConnectionAdapter;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PdoConnectionAdapter::class)]
#[CoversClass(MysqlPdoDriver::class)]
final class MysqlConnectionAdapterTest extends PdoConnectionAdapterTestCase {

    protected function connectionAdapter() : ConnectionAdapter {
        return PdoConnectionAdapter::fromConnectionAdapterConfig(
            new ConnectionAdapterConfig(
                'mysql',
                'mysql',
                3306,
                'mysql',
                'mysql'
            ),
            new MysqlPdoDriver()
        );
    }
}