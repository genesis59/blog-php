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
     * @param string $dsn
     * @param string $user
     * @param string $password
     */
    public function __construct(private readonly string $dsn, private readonly string $user, private readonly string $password)
    {
        $this->connection = $this->getConnection($this->dsn, $this->user, $this->password);
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

    /**
     * @param string $sql
     * @return array<mixed>|null
     */
    public function count(string $sql): ?array
    {
        $result = $this->connection->query($sql);
        if (!$result) {
            return null;
        }
        return $result->fetch();
    }
}
