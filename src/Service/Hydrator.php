<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\User;
use App\Model\Repository\UserRepository;

/**
 * @template T of object
 */
class Hydrator
{
    /**
     * @var bool
     */
    public bool $isEntity = false;

    public function __construct(private readonly Database $database)
    {
    }

    /**
     * @param array<string,mixed> $array
     * @param T $object
     * @return T
     */
    public function hydrate(array $array, object $object, bool $isMaster = true): object
    {
        foreach ($array as $key => $value) {
            $method = $this->getSetter($key);
            if (method_exists($object, $method)) {
                if ($this->isEntity) {
                    $object->$method($this->getEntity($method, $value, $isMaster));
                } else {
                    $object->$method($value);
                }
                $this->isEntity = false;
            } else {
                $property = $this->getProperty($key);
                $object->$property = $value;
            }
        }
        return $object;
    }

    /**
     * @param string $fieldName
     * @return string
     */
    public function getSetter(string $fieldName): string
    {
        if (str_starts_with($fieldName, 'id_')) {
            $fieldName = substr($fieldName, 3);
            $this->isEntity = true;
        }
        return 'set' . $this->fieldToPascalCase($fieldName);
    }

    /**
     * @param string $fieldName
     * @return string
     */
    public function getProperty(string $fieldName): string
    {
        return lcfirst($this->fieldToPascalCase($fieldName));
    }

    /**
     * @param string $fieldName
     * @return string
     */
    public function fieldToPascalCase(string $fieldName): string
    {
        return join(array_map('ucfirst', explode('_', $fieldName)));
    }

    /**
     * @param string $method
     * @param mixed $value
     * @return object|null
     */
    public function getEntity(string $method, mixed $value, bool $isMaster): ?object
    {
        $nameSpaceInstance = 'App\\Model\\Entity\\' . substr($method, 3);
        $instance = new $nameSpaceInstance();
        if (method_exists($instance, "setId")) {
            $instance->setId($value);
        }
        if ($isMaster) {
            $nameSpaceInstanceRepository = 'App\\Model\\Repository\\' . substr($method, 3) . 'Repository';
            $repository = new $nameSpaceInstanceRepository($this->database, new Hydrator($this->database));
            if (method_exists($instance, "getId") && method_exists($repository, "findBy")) {
                $instance = $repository->findBy(['id' => $instance->getId()], false)[0];
            }
        }
        return $instance;
    }
}
