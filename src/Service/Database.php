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
     * @param string $dsn
     * @param string $user
     * @param string $password
     * @return PDO
     */
    private function getConnection(string $dsn, string $user, string $password): PDO
    {
        try {
            return new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    /**
     * @param Environment $environment
     */
    public function __construct(private readonly Environment $environment)
    {
        $this->connection = $this->getConnection($this->environment->get("MYSQL_DSN"), $this->environment->get("MYSQL_USER"), $this->environment->get("MYSQL_PASSWORD"));
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
