<?php declare(strict_types=1);

namespace Cspray\DatabaseTesting\Pdo;

use Cspray\DatabaseTesting\Fixture\FixtureRecord;
use PDO;

abstract class GenericSqlPdoDriver implements PdoDriver {

    public function beginTransaction(PDO $pdo) : void {
        $statement = $pdo->query('START TRANSACTION');
        $statement->closeCursor();
    }

    public function rollback(PDO $pdo) : void {
        $statement = $pdo->query('ROLLBACK');
        $statement->closeCursor();
    }

    public function truncateTable(PDO $pdo, string $table) : void {
        $statement = $pdo->query(sprintf('DELETE FROM %s', $table));
        $statement->closeCursor();
    }

    public function insert(PDO $pdo, FixtureRecord $fixtureRecord) : void {
        $statement = $pdo->prepare(
            $this->generateInsertSqlForParameters($fixtureRecord)
        );
        $statement->execute($fixtureRecord->parameters);
        $statement->closeCursor();
    }

    public function selectAll(PDO $pdo, string $table) : array {
        $statement = $pdo->query(sprintf('SELECT * FROM %s', $table));
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $records;
    }

    private function generateInsertSqlForParameters(FixtureRecord $fixtureRecord) : string {
        $table = $fixtureRecord->table;
        $parameters = $fixtureRecord->parameters;
        $colsString = implode(
            ', ',
            array_keys($parameters)
        );
        $paramString = implode(
            ', ',
            array_map(static fn(string $col) => ':' . $col, array_keys($parameters))
        );
        return <<<SQL
        INSERT INTO $table ($colsString)
        VALUES ($paramString)
        SQL;
    }
}