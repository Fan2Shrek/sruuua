<?php

namespace Sruuua\Routing;

use App\Interface\ControllerInterface;
use App\Routing\Router;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route
{
    /**
     * @var string $path the route path
     */
    private string $path;

    /**
     * @var ControllerInterface the route's controller
     */
    private $controller;

    /**
     * @var \ReflectionMethod $function the method to execute
     */
    private \ReflectionMethod $function;

    /**
     * @var array|null $options the options that the route need
     */
    private ?array $options;

    /**
     * @var Router $router static router
     */
    static Router $router;

    public function __construct(string $path, $controller, \ReflectionMethod $functionName, ?array $options = null)
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->function = $functionName;
        $this->options = $options;
        self::$router->addRoute($this);
    }

    /**
     * Handle the request and execute the function
     * 
     * @return void
     */
    public function handle(): void
    {
        if (isset($this->options)) {
            $this->function->invoke($this->controller, ...$this->options);

            return;
        }
        $this->function->invoke($this->controller);

        return;
    }

    /**
     * Get the route's path
     * 
     * @return string the path
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the route's function
     * 
     * @return \ReflectionMethod the route method
     */
    public function getFunction(): \ReflectionMethod
    {
        return $this->function;
    }

    /**
     * Get the route's controller
     * 
     * @return Controller the controller class
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Get the route's options
     * 
     * @return string[]|null the option array
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Set the route's options
     * 
     * @param array $opt the option to set
     * 
     * @return void
     */
    public function modifyOption(array $opt): void
    {
        $this->options[$opt[0]] = $opt[1];
    }

    /**
     * Set the route class
     * 
     * @param Router the router instance
     * 
     * @return void
     */
    public static function setRouter(Router $router): void
    {
        Route::$router = $router;
    }


    /**
     * Get the route class' router
     * 
     * @return Router the instance of the router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }
}
