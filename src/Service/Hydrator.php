<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\User;
use App\Model\Repository\UserRepository;

/**
 * @template T
 */
class Hydrator
{
    /**
     * @var bool
     */
    public static bool $isEntity = false;

    /**
     * @param array<string,mixed> $array
     * @param object<T> $object
     * @return object<T>
     */
    public static function hydrate(array $array, object $object): object
    {
        foreach ($array as $key => $value) {
            $method = Hydrator::getSetter($key);
            if (method_exists($object, $method)) {
                if (Hydrator::$isEntity) {
                    $object->$method(Hydrator::getEntity($method, $value));
                } else {
                    $object->$method($value);
                }
                Hydrator::$isEntity = false;
            } else {
                $property = Hydrator::getProperty($key);
                $object->$property = $value;
            }
        }
        return $object;
    }

    /**
     * @param string $fieldName
     * @return string
     */
    public static function getSetter(string $fieldName): string
    {
        if (str_starts_with($fieldName, 'id_')) {
            $fieldName = substr($fieldName, 3);
            Hydrator::$isEntity = true;
        }
        return 'set' . Hydrator::fieldToPascalCase($fieldName);
    }

    /**
     * @param string $fieldName
     * @return string
     */
    public static function getProperty(string $fieldName): string
    {
        return lcfirst(Hydrator::fieldToPascalCase($fieldName));
    }

    /**
     * @param string $fieldName
     * @return string
     */
    public static function fieldToPascalCase(string $fieldName): string
    {
        return join(array_map('ucfirst', explode('_', $fieldName)));
    }

    /**
     * @param string $method
     * @param mixed $value
     * @return object<mixed>|null
     */
    public static function getEntity(string $method, mixed $value): ?object
    {
        $nameSpaceInstance = Environment::$env['NAME_SPACE_ENTITY'] . substr($method, 3);
        $instance = new $nameSpaceInstance();
        $instance->setId($value);
        return $instance;
    }
}