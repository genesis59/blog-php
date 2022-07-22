<?php

declare(strict_types=1);

namespace App\Service;

use PDO;
use PDOStatement;
use PDOException;

final class Database
{
    private PDOStatement $statement;

    public function __construct(private ?PDO $connection)
    {
        $this->connection = $this->getConnection();
    }

    public function prepare(string $sql): void
    {
        if ($this->connection) {
            $this->statement = $this->connection->prepare($sql);
        }
    }

    /**
     * @param array<mixed>|null $criteria
     * @return array<mixed>|null
     */
    public function execute(array $criteria = null): ?array
    {
        $this->statement->execute($criteria);
        return $this->statement->fetchAll();
    }

    private function getConnection(): PDO
    {
        try {
            return new PDO(MYSQL_DSN, MYSQL_USER, MYSQL_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }
}
