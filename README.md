# cspray/database-testing-pdo

A connection adapter for [`cspray/database-testing`](https://github.com/cspray/database-testing) that allows you to 
use a PDO connection for testing database interactions.

## Installation

Composer is the only supported means to install this package.

```shell
composer require --dev cspray/database-testing-pdo
```

## Quick Start

This library works by providing an implementation of the `Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapter` interface, along with a variety of `Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterFactory` implementations designed to work with common databases. Check out the example appropriate for your database below or check out the "Database Connection Adapter Reference"!

All examples below will use code from the `cspray/database-testing-phpunit` extension. If you're using a different testing framework you may need to adjust your code as appropriate.

### Postgres

```php
<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Demo;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\DatabaseCleanup\TransactionWithRollback;
use Cspray\DatabaseTesting\RequiresTestDatabase;
use Cspray\DatabaseTesting\Pdo\Postgres\PostgresConnectionAdapterFactory;
use PHPUnit\Framework\TestCase;

#[RequiresTestDatabase(
    new PostgresConnectionAdapterFactory(new ConnectionAdapterConfig(
        'my_database',
        '127.0.0.1',
        5432,
        'my_user',
        'my_password'
    )),
    new TransactionWithRollback()
)]
final class PostgresDemoTest extends TestCase {

}
```

### MySql

```php
<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Demo;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\DatabaseCleanup\TransactionWithRollback;
use Cspray\DatabaseTesting\RequiresTestDatabase;
use Cspray\DatabaseTesting\Pdo\Postgres\PostgresConnectionAdapterFactory;
use PHPUnit\Framework\TestCase;

#[RequiresTestDatabase(
    new PostgresConnectionAdapterFactory(new ConnectionAdapterConfig(
        'my_database',
        '127.0.0.1',
        5432,
        'my_user',
        'my_password'
    )),
    new TransactionWithRollback()
)]
final class PostgresDemoTest extends TestCase {

}
```

### Sqlite

```php
<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo\Demo;

use Cspray\DatabaseTesting\ConnectionAdapter\ConnectionAdapterConfig;
use Cspray\DatabaseTesting\DatabaseCleanup\TransactionWithRollback;
use Cspray\DatabaseTesting\RequiresTestDatabase;
use Cspray\DatabaseTesting\Pdo\Sqlite\SqliteConnectionAdapterFactory;
use PHPUnit\Framework\TestCase;

#[RequiresTestDatabase(
    // The default file path for Sqlite is an in-memory database
    // Provide the path to the SQL file that should be loaded when
    // the database is created
    // if you're using a persisted file, provide it as the first argument
    // and remove the initial schema path
    new SqliteConnectionAdapterFactory(
        initialSchemaPath: __DIR__ . '/schemas/sqlite.sql'
    ),
    new TransactionWithRollback()
)]
final class SqliteDemoTest extends TestCase {

}
```

## Database Connection Adapter Reference

| Database | ConnectionAdapterFactory                                               | 
| --- |------------------------------------------------------------------------|
| Postgres | `Cspray\DatabaseTesting\Pdo\Postgres\PostgresConnectionAdapterFactory` |
| MySql | `Cspray\DatabaseTesting\Pdo\Mysql\MysqlConnectionAdapterFactory`       |
| SQLite | `Cspray\DatabaseTesting\Pdo\Sqlite\SqliteConnectionAdapterFactory`     |

## Running Tests

By the nature of this library, we need to interact with a database during our tests. This presents some challenges and concessions that otherwise wouldn't be present when writing tests. Most importantly, that means we need to have multiple running database servers. To run tests for this library you must use `docker compose run --rm tests`. This will ensure the appropriate database servers are up and running so tests have something to connect to.