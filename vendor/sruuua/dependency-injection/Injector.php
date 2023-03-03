<?php

namespace Sruuua\DependencyInjection;

use ReflectionClass;

class Injector
{
    /**
     * @var Container 
     */
    private Container $container;

    public function __construct()
    {
        $this->container = (new ContainerBuilder())->buildInitialServices();
    }

    /**
     * Return all dependencies from a class
     * 
     * @param string $class Class Namespace
     * 
     * @return ReflectionNamedType[]
     */
    public function getAllDependencies(string $class): array
    {
        $types = [];
        $refClass = new ReflectionClass($class);
        $construct = $refClass->getMethod('__construct');

        $types = array_map(function ($arg) {
            return $arg->getType();
        }, $construct->getParameters());

        return $types;
    }

    /**
     * Inject dependency needed in class
     * 
     * @param string $class Class Namespace
     * 
     * @return object the instancied class
     */
    public function instance(string $class): object
    {
        $args = array_map(function ($type) {
            foreach ($this->container->getElements() as $service) {
                if ($service instanceof $type) {
                    return $this->container->get($type);
                }
            }
        }, $this->getAllDependencies($class));

        dd($args);

        $obj = new $class(...$args);


        // $this->container->set(, $obj)

        return $obj;
    }
}
