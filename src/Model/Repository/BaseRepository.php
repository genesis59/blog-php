<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\User;
use App\Model\Repository\Interfaces\EntityRepositoryInterface;
use App\Service\Database;
use App\Service\Hydrator;

/**
 * @template T of object
 * @implements EntityRepositoryInterface<T>
 */
abstract class BaseRepository implements EntityRepositoryInterface
{
    /**
     * @var class-string<T>
     */
    protected string $class;

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        $result = explode('\\', $this->class);
        return strtolower($result[count($result) - 1]);
    }

    /**
     * @param string $sql
     * @param array<string,mixed>$criteria
     * @return string
     */
    protected function addWhere(string $sql, array $criteria): string
    {
        foreach ($criteria as $key => $value) {
            if (array_key_first($criteria) === $key) {
                $sql .= ' WHERE ' . $key . '=:' . $key;
            } else {
                $sql .= ' AND ' . $key . '=:' . $key;
            }
        }
        return $sql;
    }

    /**
     * @param string $sql
     * @param array<string,string> $orderBy
     * @return string
     */
    protected function addOrderBy(string $sql, array $orderBy): string
    {
        foreach ($orderBy as $key => $value) {
            if (array_key_first($orderBy) === $key) {
                $sql .= ' ORDER BY ' . $key . ' ' . $value;
            } else {
                $sql .= ', ' . $key . ' ' . $value;
            }
        }
        return $sql;
    }

    /**
     * @param string $sql
     * @param int $limit
     * @param int|null $offset
     * @return string
     */
    protected function addLimit(string $sql, int $limit, int $offset = null)
    {
        $sql .= ' LIMIT ' . $limit;
        if ($offset) {
            $sql .= ' OFFSET ' . $offset;
        }
        return $sql;
    }

    public function __construct(protected Database $database)
    {
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function find(int $id): ?object
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * @param array<string,mixed> $criteria
     * @param array<string,string>|null $orderBy
     * @return null|object
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?object
    {
        if ($result = $this->findBy($criteria, $orderBy)) {
            return $result[0];
        }
        return null;
    }

    /**
     * @return array<object>|null
     */
    public function findAll(): ?array
    {
        return $this->findBy([]);
    }

    /**
     * @param array<string,mixed> $criteria
     * @param array<string,string>|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array<int,object>|null
     */
    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): ?array
    {
        $sql = 'SELECT * FROM ' . $this->getClassName();
        if ($criteria !== []) {
            $sql = $this->addWhere($sql, $criteria);
        }
        if ($orderBy) {
            $sql = $this->addOrderBy($sql, $orderBy);
        }
        if ($limit) {
            $sql = $this->addLimit($sql, $limit, $offset);
        }
        $this->database->prepare($sql);
        $objects = null;
        if ($result = $this->database->execute($criteria)) {
            foreach ($result as $item) {
                $objects[] = Hydrator::hydrate($item, new $this->class());
            }
        }
        return $objects;
    }

    /**
     * @param T $entity
     * @return bool
     */
    public function create(object $entity): bool
    {
        return false;
    }

    /**
     * @param T $entity
     * @return bool
     */
    public function update(object $entity): bool
    {
        return false;
    }

    /**
     * @param T $entity
     * @return bool
     */
    public function delete(object $entity): bool
    {
        if (method_exists($entity, "getId")) {
            if ($entity instanceof $this->class) {
                $this->database->prepare('DELETE FROM ' . $this->getClassName() . ' WHERE id=:id');
                $this->database->execute(['id' => $entity->getId()]);
                return true;
            }
        }
        return false;
    }
}
