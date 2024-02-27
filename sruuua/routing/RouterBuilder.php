<?php

namespace Sruuua\Routing;

use Sruuua\Routing\Route;
use Sruuua\DependencyInjection\Container;

class RouterBuilder
{
    /**
     * @var Router 
     */
    private Router $router;

    /**
     * @var Container
     */
    private Container $container;

    public function __construct(Container $container)
    {
        $this->router = new Router();
        $this->container = $container;
        $this->init('Sruuua\Routing\Interface\ControllerInterface');
    }

    /**
     * Get the Router value
     * 
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Init all controller
     * 
     * @param string $interface the controller interface
     * 
     * @return void
     */
    public function init(string $interface)
    {
        foreach ($this->container->getAllByType($interface) as $controller) {
            $this->registerController($controller);
        }
    }

    /**
     * Init a controller
     * 
     * @param ControllerInterface $InitialClass the controller to init
     */
    public function registerController($InitialClass)
    {
        $class = new \ReflectionClass($InitialClass);

        $methods = $class->getMethods();

        foreach ($methods as $method) {
            $attributes = $method->getAttributes(Route::class);
            $options = [];

            if ('__construct' !== $method->getName()) {
                foreach ($method->getParameters() as $param) {
                    $options[] = $param;
                }
            }

            $options = array_combine(array_map(fn ($opt) => $opt->getName(), $options), $options);

            foreach ($attributes as $attribute) {
                new Route($attribute->getArguments()[0], $InitialClass, $method, ($options ?? null));
            }
        }
    }
}
