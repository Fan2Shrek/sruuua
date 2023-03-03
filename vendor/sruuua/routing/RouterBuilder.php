<?php

namespace Sruuua\Routing;

use Sruuua\Routing\Route;
use Sruuua\Interface\ControllerInterface;

class RouterBuilder
{
    /**
     * @var Router $router
     */
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
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
     * @return void
     */
    public function init()
    {
        $controller = '';
        $this->registerController($controller);
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

            if ($method->getName() === 'view') {
                foreach ($method->getParameters() as $param) {
                    $type = $param->getType();
                    $options[$param->getName()] = $type->getName();
                }
            }

            foreach ($attributes as $attribute) {
                new Route($attribute->getArguments()[0], $InitialClass, $method, ($options ?? null));
            }
        }
    }
}
