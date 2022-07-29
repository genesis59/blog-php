<?php

namespace App\Service;

class Hydrator
{
    public static function hydrate(array $array, object $object) : object
    {
        foreach ($array as $key => $value) {
            $method = Hydrator::getSetter($key);
            if (method_exists($object, $method)) {
                $object->$method($value);
            } else {
                $property = Hydrator::getProperty($key);
                $object->$property = $value;
            }
        }
        return $object;
    }

    public static function getSetter(string $fieldName): string
    {
        return 'set' . Hydrator::fieldToPascalCase($fieldName);
    }

    public static function getProperty(string $fieldName): string
    {
        return lcfirst(Hydrator::fieldToPascalCase($fieldName));
    }

    public static function fieldToPascalCase(string $fieldName): string
    {
        return join(array_map('ucfirst', explode('_', $fieldName)));
    }
}