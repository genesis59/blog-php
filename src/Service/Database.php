<?php

declare(strict_types=1);

namespace App\Service;

use PDO;
use PDOStatement;
use PDOException;

final class Database
{
    /**
     * @var PDOStatement
     */
    private PDOStatement $statement;

    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * @return PDO
     */
    private function getConnection(): PDO
    {
        try {
            return new PDO(Environment::$env['MYSQL_DSN'], Environment::$env['MYSQL_USER'], Environment::$env['MYSQL_PASSWORD'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    /**
     * @param string $sql
     * @return void
     */
    public function prepare(string $sql): void
    {
        $this->statement = $this->connection->prepare($sql);
    }

    /**
     * @param array<mixed>|null $criteria
     * @return array<mixed>|null
     */
    public function execute(array $criteria = null): ?array
    {
        $this->statement->execute($criteria);
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
