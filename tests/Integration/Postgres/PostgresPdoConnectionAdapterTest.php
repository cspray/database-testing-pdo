<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Integration\Postgres;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapter;
use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\Internal\ConnectionAdapterTestCase;
use Cspray\DatabaseTesting\Pdo\Integration\PdoConnectionAdapterTestCase;
use Cspray\DatabaseTesting\Pdo\PdoConnectionAdapter;
use Cspray\DatabaseTesting\Pdo\Postgres\PostgresPdoDriver;
use PDO;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PdoConnectionAdapter::class)]
#[CoversClass(PostgresPdoDriver::class)]
/**
 * @template-extends ConnectionAdapterTestCase<PDO>
 */
final class PostgresPdoConnectionAdapterTest extends PdoConnectionAdapterTestCase {

    /**
     * @return ConnectionAdapter<PDO>
     */
    protected function connectionAdapter() : ConnectionAdapter {
        return PdoConnectionAdapter::fromConnectionAdapterConfig(
            new ConnectionAdapterConfig(
                'postgres',
                'postgres',
                5432,
                'postgres',
                'postgres'
            ),
            new PostgresPdoDriver()
        );
    }

}