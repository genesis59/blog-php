<?php

declare(strict_types=1);

namespace App\Model\Repository\Interfaces;

/**
 * @template T of object
 */
interface EntityRepositoryInterface
{
    /**
     * @param int $id
     * @return T|null
     */
    public function find(int $id): ?object;

    /**
     * @param array<string,mixed> $criteria
     * @param array<string,string>|null $orderBy
     * @return null|T
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?object;

    /**
     * @return array<T>|null
     */
    public function findAll(): ?array;

    /**
     * @param array<string,mixed> $criteria
     * @param array<string,string>|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array<int,object>|null
     */
    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): ?array;

    /**
     * @param T $entity
     * @return bool
     */
    public function create(object $entity): bool;

    /**
     * @param T $entity
     * @return bool
     */
    public function update(object $entity): bool;

    /**
     * @param T $entity
     * @return bool
     */
    public function delete(object $entity): bool;

    /**
     * @param array<string,mixed> $criteria
     * @return int
     */
    public function count(array $criteria = []): int;

    /**
     * @param T $entity
     * @return object|null
     */
    public function getPreviousEntity(object $entity): ?object;

    /**
     * @param T $entity
     * @return object|null
     */
    public function getNextEntity(object $entity): ?object;
}
