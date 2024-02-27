<?php

namespace Sruuua\Database\Hydrator;

use Sruuua\Database\Hydrator\Exception\SetterNotFoundException;
use Sruuua\Database\Result\Result;

/**
 * Hydrate a result query into an object
 */
class Hydrator
{
    /**
     * Return the hydrate object with the given param
     * 
     * @param object $object object to hydrate
     * @param array[string]string $values associative array with propertie => value couple 
     * 
     * @throws SetterNotFoundException
     * 
     * @return object hydrated object
     */
    public function hydrateObject(object $object, array $values): object
    {
        $class = new \ReflectionClass($object::class);

        foreach ($values as $property => $val) {
            $setter = 'set' . ucfirst($property);
            if ($class->hasMethod($setter))
                $object->$setter($val);
            else
                throw new SetterNotFoundException(sprintf("The setter set%s() was not found in %s", ucfirst($property), $object::class));
        }

        return $object;
    }

    public function hydrateResult(Result $statement, string $class)
    {
        $allObjects = array();
        foreach ($statement->fetchAllAssociative() as $object) {
            $obj = new $class();

            $allObjects[] = $this->hydrateObject($obj, $object);
        }

        return $allObjects;
    }
}
